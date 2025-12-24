import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior() {
    return { top: 0 };
  },
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("../views/HomeView.vue"),
      meta: { guest: true },
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../views/auth/LoginView.vue"),
      meta: { guest: true },
    },
    {
      path: "/register",
      name: "register",
      component: () => import("../views/auth/RegisterView.vue"),
      meta: { guest: true },
    },
    {
      path: "/forgot-password",
      name: "forgot-password",
      component: () => import("../views/auth/ForgotPasswordView.vue"),
      meta: { guest: true },
    },
    {
      path: "/reset-password",
      name: "reset-password",
      component: () => import("../views/auth/ResetPasswordView.vue"),
      meta: { guest: true },
    },
    {
      path: "/dashboard",
      meta: { requiresAuth: true },
      children: [
        {
          path: "",
          name: "dashboard",
          component: () => import("../views/dashboard/DashboardView.vue"),
        },
        {
          path: "services",
          name: "services",
          component: () => import("../views/dashboard/ServicesView.vue"),
        },
        {
          path: "availabilities",
          name: "availabilities",
          component: () => import("../views/dashboard/AvailabilitiesView.vue"),
        },
        {
          path: "profile",
          name: "profile",
          component: () => import("../views/dashboard/ProfileView.vue"),
        },
      ],
    },
    {
      path: "/subscription/success",
      name: "subscription-success",
      component: () => import("../views/SubscriptionSuccessView.vue"),
      meta: { requiresAuth: false },
    },
    {
      path: "/subscription/cancel",
      name: "subscription-cancel",
      component: () => import("../views/SubscriptionCancelView.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/cancel/:token",
      name: "cancel-booking",
      component: () => import("../views/public/CancelBookingView.vue"),
    },
    {
      path: "/booking-confirmation",
      name: "booking-confirmation",
      component: () => import("../views/public/BookingConfirmationView.vue"),
    },
    {
      path: "/error",
      name: "error",
      component: () => import("../views/ErrorView.vue"),
    },
    {
      path: "/privacy",
      name: "privacy",
      component: () => import("../views/legal/PrivacyView.vue"),
    },
    {
      path: "/terms",
      name: "terms",
      component: () => import("../views/legal/TermsView.vue"),
    },
    {
      path: "/:slug",
      name: "public-professional",
      component: () => import("../views/public/ProfessionalView.vue"),
    },
    {
      path: "/:pathMatch(.*)*",
      name: "not-found",
      component: () => import("../views/NotFoundView.vue"),
    },
  ],
});

router.beforeEach(async (to) => {
  const authStore = useAuthStore();

  if (!to.meta.requiresAuth && !to.meta.guest) return true;

  if (to.meta.requiresAuth && authStore.user === null && !authStore.loading) {
    try {
      await authStore.fetchUser();
    } catch (error) {
      return { name: "login" };
    }
  }

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return { name: "login" };
  }

  if (to.meta.guest && authStore.isAuthenticated) {
    return { name: "dashboard" };
  }

  return true;
});

export default router;
