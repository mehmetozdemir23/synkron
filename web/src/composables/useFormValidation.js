import { ref } from "vue";

export function useFormValidation(initialData = {}) {
  const formData = ref({ ...initialData });
  const fieldErrors = ref({});
  const error = ref("");
  const loading = ref(false);

  const reset = () => {
    formData.value = { ...initialData };
    fieldErrors.value = {};
    error.value = "";
  };

  const clearErrors = () => {
    fieldErrors.value = {};
    error.value = "";
  };

  const setFieldErrors = (errors) => {
    if (!errors) return;

    const newErrors = {};
    Object.keys(errors).forEach((key) => {
      if (Array.isArray(errors[key])) {
        newErrors[key] = errors[key][0];
      } else {
        newErrors[key] = errors[key];
      }
    });
    fieldErrors.value = newErrors;
  };

  const setError = (message) => {
    error.value = message;
  };

  const setLoading = (isLoading) => {
    loading.value = isLoading;
  };

  return {
    formData,
    fieldErrors,
    error,
    loading,
    reset,
    clearErrors,
    setFieldErrors,
    setError,
    setLoading,
  };
}
