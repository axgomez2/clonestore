import "./bootstrap"
import Alpine from "alpinejs"

window.Alpine = Alpine


document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM fully loaded")

  document.addEventListener("alpine:init", () => {
    console.log("Alpine initialized")

    Alpine.data("vinylCard", () => ({
      init() {
        console.log("vinylCard component initialized")
        console.log("this.$el:", this.$el)
      },
      playVinylTracks() {
        console.log("playVinylTracks called")
        console.log("this.$el:", this.$el)
        const button = this.$refs.playButton
        console.log("Play button:", button)
        if (!button) {
          console.error("Play button not found. Element structure:", this.$el.innerHTML)
          return
        }
        const tracks = JSON.parse(button.dataset.tracks || "[]")
        console.log("Tracks:", tracks)

        if (tracks.length > 0) {
          const randomTrack = tracks[Math.floor(Math.random() * tracks.length)]
          const trackData = {
            id: button.dataset.vinylId,
            name: randomTrack.name,
            artist: button.dataset.artist,
            youtube_url: randomTrack.youtube_url,
          }

          console.log("Track data:", trackData)
          if (trackData.youtube_url) {
            console.log("Loading track")
            Alpine.store("audioPlayer").loadTrack(trackData, tracks)
          } else {
            console.error("No YouTube URL available for this track")
            // You can add a user notification here
          }
        } else {
          console.error("No tracks available for this vinyl")
          // You can add a user notification here
        }
      },
      formatPrice(price) {
        return parseFloat(price).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },

    addToCart() {
        // Implemente a lógica de adicionar ao carrinho aqui
        console.log('Adding to cart:', this.id);
    },

    toggleFavorite() {
        // Implemente a lógica de alternar favorito aqui
        this.inWishlist = !this.inWishlist;
        console.log('Toggling favorite:', this.id, 'New state:', this.inWishlist);
    },

    }))

    Alpine.data("trackCards", () => ({
      init() {
        console.log("Vinyl cards script loaded")
        this.setupPlayButtons()
      },
      setupPlayButtons() {
        const playButtons = document.querySelectorAll(".track-play-button")
        console.log("Found " + playButtons.length + " play buttons")
        // ... rest of the function
      },
    }))
  })





  Alpine.start()
  console.log("Alpine started")
})

