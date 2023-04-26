const openAlertButtons = querySelectorAll('[data-alert-target]')
const closeAlertButtons = querySelectorAll('[data-close-button]')
const overlay = getElementById('overlay')

openAlertButtons.forEach(button => {
  button.addEventListener("click", () => {
    const alert = document.querySelector(button.dataset.alertTarget)
    openAlert(alert)
  })
})

closeAlertButtons.forEach(button => {
  button.addEventListener("click", () => {
    const alert = button.closest('.alert')
    closeAlert(alert)
  })
})

function openAlert(alert) {
  if (alert == null) return
  alert.classList.add("active")
  overlay.classList.add("active")
}

function closeAlert(alert) {
  if (alert == null) return
  alert.classList.remove("active")
  overlay.classList.remove("active")
}
