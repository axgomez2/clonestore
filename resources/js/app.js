import "./bootstrap"
import Alpine from "alpinejs"

window.Alpine = Alpine

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM fully loaded")

  document.addEventListener("alpine:init", () => {
    console.log("Alpine initialized")




  })

  Alpine.start()
  console.log("Alpine started")
})
