<div id="custom-player"
x-data
class="fixed bottom-0 left-0 right-0 bg-slate-300 border-t border-base-300 p-4 hidden z-50">
<div class="container mx-auto">
   <div class="flex items-center gap-4">
       <!-- Controles de reprodução -->
       <div class="flex items-center gap-2">
           <button id="prev-button" @click="$store.audioPlayer.playPrevious()" :class="{ 'disabled': $store.audioPlayer.currentTrackIndex === 0 }" class="btn btn-circle btn-sm">
               <i class="fas fa-step-backward"></i>
           </button>
           <button id="play-button" @click="$store.audioPlayer.togglePlay()" class="btn btn-circle btn-primary">
               <i class="fas" :class="$store.audioPlayer.isPlaying ? 'fa-pause' : 'fa-play'"></i>
           </button>
           <button id="next-button" @click="$store.audioPlayer.playNext()" :class="{ 'disabled': $store.audioPlayer.currentTrackIndex === $store.audioPlayer.playlist.length - 1 }" class="btn btn-circle btn-sm">
               <i class="fas fa-step-forward"></i>
           </button>
       </div>

       <!-- Informações da faixa -->
       <div class="flex-1">
           <div id="track-title" class="text-sm font-medium" x-text="$store.audioPlayer.currentTrack?.name"></div>
           <div id="track-artist" class="text-xs text-base-content/60" x-text="$store.audioPlayer.currentTrack?.artist"></div>
       </div>

       <!-- Barra de progresso -->
       <div class="flex-1">
           <div id="progress-container" class="h-2 bg-base-300 rounded-full cursor-pointer" @click="$store.audioPlayer.seek($event)">
               <div id="progress-bar" class="h-full bg-primary rounded-full" :style="{ width: `${$store.audioPlayer.progress}%` }"></div>
           </div>
           <div class="flex justify-between text-xs mt-1">
               <span id="current-time" x-text="$store.audioPlayer.formatTime($store.audioPlayer.currentTime)"></span>
               <span id="duration" x-text="$store.audioPlayer.formatTime($store.audioPlayer.duration)"></span>
           </div>
       </div>

       <!-- Controle de volume -->
       <div class="flex items-center gap-2">
           <button id="volume-button" @click="$store.audioPlayer.toggleMute()" class="btn btn-ghost btn-sm btn-circle">
               <i class="fas" :class="$store.audioPlayer.volumeIcon"></i>
           </button>
           <input
               type="range"
               id="volume-slider"
               min="0"
               max="1"
               step="0.1"
               x-model="$store.audioPlayer.volume"
               @input="$store.audioPlayer.setVolume($event.target.value)"
               class="range range-xs range-primary w-20"
           >
       </div>
   </div>
</div>
<div id="youtube-player"></div>
</div>
