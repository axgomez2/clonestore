console.log("audio-player.js loaded")
document.addEventListener("alpine:init", () => {
  Alpine.store("audioPlayer", {
    isPlaying: false,
    currentTrack: null,
    playlist: [],
    currentTrackIndex: 0,
    progress: 0,
    currentTime: 0,
    duration: 0,
    volume: 1,
    youtubePlayer: null,

    init() {
      this.loadYouTubeAPI()
    },

    loadYouTubeAPI() {
      if (!window.YT) {
        const tag = document.createElement("script")
        tag.src = "https://www.youtube.com/iframe_api"
        const firstScriptTag = document.getElementsByTagName("script")[0]
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag)
      }

      if (typeof YT === "undefined" || !YT.Player) {
        window.onYouTubeIframeAPIReady = this.initializeYouTubePlayer.bind(this)
      } else {
        this.initializeYouTubePlayer()
      }
    },

    initializeYouTubePlayer() {
      if (typeof YT !== "undefined" && YT.Player) {
        this.createYouTubePlayer()
      } else {
        console.error("YouTube API not loaded, retrying in 1 second")
        setTimeout(() => this.initializeYouTubePlayer(), 1000)
      }
    },

    createYouTubePlayer() {
      if (!document.getElementById("youtube-player")) {
        const playerDiv = document.createElement("div")
        playerDiv.id = "youtube-player"
        document.body.appendChild(playerDiv)
      }

      this.youtubePlayer = new YT.Player("youtube-player", {
        height: "0",
        width: "0",
        videoId: "",
        playerVars: {
          autoplay: 0,
          controls: 0,
        },
        events: {
          onReady: this.onPlayerReady.bind(this),
          onStateChange: this.onPlayerStateChange.bind(this),
        },
      })
    },

    onPlayerReady(event) {
      console.log("YouTube player is ready")
    },

    onPlayerStateChange(event) {
      if (event.data === YT.PlayerState.PLAYING) {
        this.isPlaying = true
        this.startProgressUpdate()
      } else if (event.data === YT.PlayerState.PAUSED) {
        this.isPlaying = false
      } else if (event.data === YT.PlayerState.ENDED) {
        this.playNext()
      }
    },

    loadTrack(track, allTracks) {
      console.log("Loading track:", track)
      this.currentTrack = track
      this.playlist = Array.isArray(allTracks) ? allTracks : [track]
      this.currentTrackIndex = this.playlist.findIndex((t) => t.id === track.id)

      document.getElementById("custom-player").classList.remove("hidden")

      const videoId = this.extractYouTubeId(track.youtube_url)
      if (this.youtubePlayer && this.youtubePlayer.loadVideoById) {
        this.youtubePlayer.loadVideoById(videoId)
        this.play()
      } else {
        console.error("YouTube player not initialized")
        this.loadYouTubeAPI()
      }
    },

    togglePlay() {
      this.isPlaying ? this.pause() : this.play()
    },

    play() {
      if (this.youtubePlayer && this.youtubePlayer.playVideo) {
        this.youtubePlayer.playVideo()
        this.isPlaying = true
      }
    },

    pause() {
      if (this.youtubePlayer && this.youtubePlayer.pauseVideo) {
        this.youtubePlayer.pauseVideo()
        this.isPlaying = false
      }
    },

    setVolume(value) {
      this.volume = value
      if (this.youtubePlayer && this.youtubePlayer.setVolume) {
        this.youtubePlayer.setVolume(value * 100)
      }
    },

    toggleMute() {
      if (this.youtubePlayer) {
        if (this.youtubePlayer.isMuted()) {
          this.youtubePlayer.unMute()
          this.volume = this.youtubePlayer.getVolume() / 100
        } else {
          this.youtubePlayer.mute()
          this.volume = 0
        }
      }
    },

    seek(event) {
      if (this.youtubePlayer && this.youtubePlayer.getDuration) {
        const percent = event.offsetX / event.target.offsetWidth
        const newTime = percent * this.youtubePlayer.getDuration()
        this.youtubePlayer.seekTo(newTime, true)
      }
    },

    startProgressUpdate() {
      setInterval(() => {
        if (this.youtubePlayer && this.youtubePlayer.getCurrentTime && this.youtubePlayer.getDuration) {
          this.currentTime = this.youtubePlayer.getCurrentTime()
          this.duration = this.youtubePlayer.getDuration()
          this.progress = (this.currentTime / this.duration) * 100
        }
      }, 1000)
    },

    formatTime(seconds) {
      const minutes = Math.floor(seconds / 60)
      const remainingSeconds = Math.floor(seconds % 60)
      return `${minutes}:${remainingSeconds.toString().padStart(2, "0")}`
    },

    playNext() {
      if (this.currentTrackIndex < this.playlist.length - 1) {
        this.currentTrackIndex++
        const nextTrack = this.playlist[this.currentTrackIndex]
        this.loadTrack(nextTrack, this.playlist)
      }
    },

    playPrevious() {
      if (this.currentTrackIndex > 0) {
        this.currentTrackIndex--
        const prevTrack = this.playlist[this.currentTrackIndex]
        this.loadTrack(prevTrack, this.playlist)
      }
    },

    extractYouTubeId(url) {
      const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/
      const match = url.match(regExp)
      return match && match[2].length === 11 ? match[2] : null
    },

    get volumeIcon() {
      if (this.volume == 0) {
        return "fa-volume-mute"
      } else if (this.volume < 0.5) {
        return "fa-volume-down"
      } else {
        return "fa-volume-up"
      }
    },
  })
})

