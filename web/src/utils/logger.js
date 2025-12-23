const isDevelopment = import.meta.env.DEV;

function sanitizeError(error) {
  if (!error) return null;

  const sanitized = {
    message: error.message || "An error occurred",
    type: error.constructor?.name || "Error",
  };

  if (isDevelopment && error.stack) {
    sanitized.stack = error.stack;
  }

  if (error.response?.data) {
    sanitized.response = {
      status: error.response.status,
      statusText: error.response.statusText,

      message: error.response.data?.message || error.response.data?.error,
    };
  }

  return sanitized;
}

export function logError(context, error, metadata = {}) {
  const sanitizedError = sanitizeError(error);

  if (isDevelopment) {
    console.error(`[${context}]`, sanitizedError, metadata);
  } else {
    console.error(`[${context}]`, sanitizedError?.message || "Error occurred");
  }
}
