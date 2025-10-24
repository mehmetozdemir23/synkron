export function useFormatters() {
  function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString("fr-FR", {
      hour: "2-digit",
      minute: "2-digit",
    });
  }

  function formatDateShort(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("fr-FR", {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
    });
  }

  function formatDateFull(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("fr-FR", {
      weekday: "long",
      day: "numeric",
      month: "long",
      year: "numeric",
    });
  }

  function formatMonthYear(date) {
    return date.toLocaleDateString("fr-FR", {
      month: "long",
      year: "numeric",
    });
  }

  return {
    formatTime,
    formatDateShort,
    formatDateFull,
    formatMonthYear,
  };
}
