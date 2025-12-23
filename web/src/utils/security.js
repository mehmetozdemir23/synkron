export function safeRedirect(url, options = {}) {
  const {
    allowedProtocols = ["http:", "https:"],
    allowedDomains = null,
    fallbackUrl = "/",
  } = options;

  if (!url || typeof url !== "string") {
    console.warn("[Security] Invalid URL provided for redirect");
    window.location.href = fallbackUrl;
    return false;
  }

  try {
    const parsedUrl = new URL(url, window.location.origin);

    if (!allowedProtocols.includes(parsedUrl.protocol)) {
      console.warn(`[Security] Invalid protocol: ${parsedUrl.protocol}`);
      window.location.href = fallbackUrl;
      return false;
    }

    if (allowedDomains && !allowedDomains.includes(parsedUrl.hostname)) {
      console.warn(`[Security] Domain not allowed: ${parsedUrl.hostname}`);
      window.location.href = fallbackUrl;
      return false;
    }

    window.location.href = url;
    return true;
  } catch (error) {
    console.warn("[Security] Invalid URL format:", error.message);
    window.location.href = fallbackUrl;
    return false;
  }
}
