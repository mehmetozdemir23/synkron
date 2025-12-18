import { defineStore } from "pinia";
import { ref } from "vue";

export const useAlertStore = defineStore("alert", () => {
  const show = ref(false);
  const message = ref("");
  const title = ref("");
  const type = ref("info");
  let resolvePromise = null;

  function showAlert({
    message: msg,
    title: titleText = "Information",
    type: alertType = "info",
  }) {
    return new Promise((resolve) => {
      message.value = msg;
      title.value = titleText;
      type.value = alertType;
      show.value = true;
      resolvePromise = resolve;
    });
  }

  function close() {
    show.value = false;
    if (resolvePromise) {
      resolvePromise();
      resolvePromise = null;
    }
  }

  function error(msg, titleText = "Erreur") {
    return showAlert({ message: msg, title: titleText, type: "error" });
  }

  function success(msg, titleText = "Succès") {
    return showAlert({ message: msg, title: titleText, type: "success" });
  }

  function warning(msg, titleText = "Attention") {
    return showAlert({ message: msg, title: titleText, type: "warning" });
  }

  function info(msg, titleText = "Information") {
    return showAlert({ message: msg, title: titleText, type: "info" });
  }

  return {
    show,
    message,
    title,
    type,
    showAlert,
    close,
    error,
    success,
    warning,
    info,
  };
});
