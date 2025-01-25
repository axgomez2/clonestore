document.addEventListener("alpine:init", () => {
    Alpine.data("trackCards", () => ({
      init() {
        console.log("Vinyl cards script loaded")
        this.setupPlayButtons()
      },
      setupPlayButtons() {
        const playButtons = document.querySelectorAll(".track-play-button")
        console.log("Found " + playButtons.length + " play buttons")

        playButtons.forEach((button) => {
          button.addEventListener("click", (event) => {
            event.preventDefault()

            const tracks = JSON.parse(button.dataset.tracks)
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
              // Você pode adicionar aqui uma notificação para o usuário
            }
          })
        })
      },
    }))
  })

