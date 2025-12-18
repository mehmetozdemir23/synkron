import axios from "axios";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || "http://localhost:8000/api",
  withCredentials: true,
  withXSRFToken: true,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

const webBaseURL =
  import.meta.env.VITE_API_URL?.replace(/\/api\/?$/, "") ||
  "http://localhost:8000";

const webAPI = axios.create({
  baseURL: webBaseURL,
  withCredentials: true,
  withXSRFToken: true,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

export async function getCsrfCookie() {
  const baseURL =
    import.meta.env.VITE_API_URL?.replace(/\/api\/?$/, "") ||
    "http://localhost:8000";
  await axios.get(`${baseURL}/sanctum/csrf-cookie`, { withCredentials: true });
}

export const authAPI = {
  register: (data) =>
    webAPI.post("/auth/register", data, {
      headers: {
        "X-Timezone": Intl.DateTimeFormat().resolvedOptions().timeZone,
      },
    }),
  login: (data) => webAPI.post("/auth/login", data),
  logout: () => api.post("/auth/logout"),
  me: () => api.get("/auth/me"),
  googleCallback: (data) => api.post("/auth/google/callback", data),
};

export const profileAPI = {
  update: (data) => api.put("/profile", data),
  updatePassword: (data) => api.put("/profile/password", data),
};

export const statsAPI = {
  get: () => api.get("/stats"),
};

export const servicesAPI = {
  getAll: () => api.get("/services"),
  get: (id) => api.get(`/services/${id}`),
  create: (data) => api.post("/services", data),
  update: (id, data) => api.put(`/services/${id}`, data),
  delete: (id) => api.delete(`/services/${id}`),
};

export const availabilitiesAPI = {
  getAll: () => api.get("/availabilities"),
  upsert: (data) => api.post("/availabilities", data),
};

export const bookingsAPI = {
  getAll: (params = {}) => api.get("/bookings", { params }),
  get: (id) => api.get(`/bookings/${id}`),
  confirm: (id) => api.post(`/bookings/${id}/confirm`),
  reject: (id) => api.post(`/bookings/${id}/reject`),
  cancel: (id) => api.post(`/bookings/${id}/cancel`),
};

export const publicAPI = {
  getProfessional: (slug) => api.get(`/public/${slug}`),
  getAvailableSlots: (slug, serviceId, params) =>
    api.get(`/public/${slug}/services/${serviceId}/slots`, { params }),
  createBooking: (slug, serviceId, data) =>
    api.post(`/public/${slug}/services/${serviceId}/bookings`, data),
  cancelBooking: (token) => api.post(`/public/bookings/${token}/cancel`),
  getBooking: (bookingId) => api.get(`/public/bookings/${bookingId}`),
};

export const subscriptionAPI = {
  getStatus: () => api.get("/subscription/status"),
  checkout: () => api.post("/subscription/checkout"),
  openPortal: () => api.post("/subscription/portal"),
  cancel: () => api.post("/subscription/cancel"),
  resume: () => api.post("/subscription/resume"),
};

export const passwordResetAPI = {
  sendResetLink: (data) => webAPI.post("/auth/forgot-password", data),
  resetPassword: (data) => webAPI.post("/auth/reset-password", data),
};

export default api;
