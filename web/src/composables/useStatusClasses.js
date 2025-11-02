export function useStatusClasses() {
  function getStatusBadgeClass(status) {
    const classes = {
      pending: "bg-warning-100 text-warning-700 border border-warning-200",
      confirmed: "bg-success-100 text-success-700 border border-success-200",
      cancelled: "bg-error-100 text-error-700 border border-error-200",
      rejected: "bg-error-100 text-error-700 border border-error-200",
    };
    return classes[status] || "bg-neutral-100 text-neutral-700 border border-neutral-200";
  }

  function getStatusLabel(status) {
    const labels = {
      pending: "En attente",
      confirmed: "Confirmée",
      cancelled: "Annulée",
      rejected: "Rejetée",
    };
    return labels[status] || status;
  }

  function getStatusColor(status) {
    const colors = {
      pending: "bg-warning-500",
      confirmed: "bg-success-500",
      cancelled: "bg-error-500",
      rejected: "bg-error-500",
    };
    return colors[status] || "bg-neutral-500";
  }

  return {
    getStatusBadgeClass,
    getStatusLabel,
    getStatusColor,
  };
}
