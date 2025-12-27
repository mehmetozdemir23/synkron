export function useFormatters() {
  function formatTime(dateString, timezone = undefined) {
    const date = new Date(dateString);
    const options = {
      hour: "2-digit",
      minute: "2-digit",
    };
    if (timezone) {
      options.timeZone = timezone;
    }
    return date.toLocaleTimeString("fr-FR", options);
  }

  function formatDayName(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("fr-FR", {
      weekday: "long",
    });
  }

  function formatDayNumber(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("fr-FR", {
      day: "2-digit",
      month: "short",
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

  function formatFullDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("fr-FR", {
      weekday: "long",
      day: "numeric",
      month: "long",
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
    formatDayName,
    formatDayNumber,
    formatDateShort,
    formatDateFull,
    formatFullDate,
    formatMonthYear,
  };
}
