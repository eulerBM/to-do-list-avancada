export function showAlert(status, message, show = true) {

  if (!show) return;

    function createAlert(messageJson, type) {

      const alert = document.createElement("div");
      alert.className = `alert alert-${type}`;
      alert.role = "alert";
      alert.textContent = messageJson;

      document.body.prepend(alert);

      setTimeout(() => alert.remove(), 5000);

    }

  if (status >= 500) {
    return createAlert(message, "danger")
  }
  if (status >= 400) {
    return createAlert(message, "warning")
  }
  if (status >= 300) {
    return createAlert(message, "info")
  }
  if (status >= 200) {
    return createAlert(message, "success")
  }
}
