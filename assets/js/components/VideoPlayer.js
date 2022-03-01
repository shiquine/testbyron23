export class VideoPlayer {
  constructor({ container }) {
    this.container = container;
    this.video = false;

    this.attributes = {
      video: 'data-video',
      playing: 'data-playing',
      muted: 'data-muted',
    };

    //  Player state
    this.isPlaying = false;
    this.isMuted = false;
  }

  mount() {
    if (!this.container) return;

    this.getVideo();

    //  Check that the video is not null. This might happen if the start
    //  function runs before the video is fully usable in the DOM
    const interval = setInterval(() => {
      if (this.video) {
        clearInterval(interval);
        this.start();
      } else {
        this.getVideo();
      }
    }, 100);
  }

  getVideo() {
    this.video = this.container.querySelector(`[${this.attributes.video}]`);
  }

  start() {
    this.setUpVideo();
  }

  setUpVideo() {
    this.video.addEventListener('play', event => this.onPlay(event));
    this.video.addEventListener('pause', event => this.onPause(event));
    this.video.addEventListener('ended', event => this.onStop(event));
    this.video.addEventListener('mute', event => this.onMute(event));
    this.video.addEventListener('unmute', event => this.onUnmute(event));
    this.video.addEventListener('volumechange', event =>
      this.handleMute(event)
    );
  }

  togglePlay() {
    if (this.isPlaying) {
      this.pause();
    } else {
      this.play();
    }
  }

  //  It’s useful to separate functions like `play()` and `onPlay()` here.
  //  `play()` should just play the video — simple. `onPlay()` should react
  //  to the play event.
  //  The reason is that we won’t necessarily be the ones that trigger the
  //  play event, the browser may do so outside of our players controls.
  play() {
    this.video.play();
  }

  onPlay() {
    this.isPlaying = true;
    this.container.setAttribute(this.attributes.playing, '');
  }

  pause() {
    this.video.pause();
  }

  onPause() {
    this.isPlaying = false;
    this.container.removeAttribute(this.attributes.playing);
  }

  onStop() {
    this.isPlaying = false;
    this.container.removeAttribute(this.attributes.playing);
  }

  setPlaybackTime(time) {
    this.video.currentTime = time;
  }

  toggleMute() {
    this.video.muted = !this.video.muted;
  }

  mute() {
    this.video.muted = true;
  }

  unmute() {
    this.video.muted = false;
  }

  handleMute() {
    //  This function runs after the video state has changed
    if (this.video.muted) {
      this.onMute();
    } else {
      this.onUnmute();
    }
  }

  onMute() {
    this.isMuted = true;
    this.container.setAttribute(this.attributes.muted, '');
  }

  onUnmute() {
    this.isMuted = false;
    this.container.removeAttribute(this.attributes.muted);
  }

  destroy() {
    this.pause();

    this.video.removeEventListener('play', event => this.onPlay(event));
    this.video.removeEventListener('pause', event => this.onPause(event));
    this.video.removeEventListener('ended', event => this.onStop(event));
    this.video.removeEventListener('volumechange', event =>
      this.handleMute(event)
    );
  }
}
