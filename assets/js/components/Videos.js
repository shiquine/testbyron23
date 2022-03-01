import { VideoPlayer } from './VideoPlayer';

export class Videos {
  constructor() {
    this.attributes = {
      container: 'data-video-container',
      playToggle: 'data-video-play-toggle',
      muteToggle: 'data-video-mute-toggle',
    };

    this.containers = [];
    this.players = [];

    //  Bind event listeners
    this.handleClick = this.handleClick.bind(this);
  }

  start() {
    this.setVars();
    this.setUpPlayers();
    this.listenForClick();
  }

  setVars() {
    this.containers = Array.from(
      document.querySelectorAll(`[${this.attributes.container}]`)
    );
    this.players = [];
  }

  setUpPlayers() {
    this.containers.forEach(container => {
      this.createPlayer(container);
    });
  }

  createPlayer(container) {
    const player = new VideoPlayer({ container });
    player.mount();

    this.players.push({
      container,
      player,
    });
  }

  listenForClick() {
    document.body.addEventListener('click', this.handleClick, {
      capture: true,
    });
  }

  handleClick(event) {
    this.togglePlay(event);
    this.toggleMute(event);
  }

  togglePlay(event) {
    const button = this.getPlayToggleFromEvent(event);
    const playerObject = this.getPlayerObjectFromEvent(event);
    if (!button || !playerObject) return;

    event.preventDefault();
    event.stopPropagation();

    const { player } = playerObject;
    player.togglePlay();
  }

  getPlayToggleFromEvent(event) {
    return event.target.closest(`[${this.attributes.playToggle}]`);
  }

  toggleMute(event) {
    const button = this.getMuteToggleFromEvent(event);
    const playerObject = this.getPlayerObjectFromEvent(event);
    if (!button || !playerObject) return;

    event.preventDefault();
    event.stopPropagation();

    const { player } = playerObject;
    player.toggleMute();
  }

  getMuteToggleFromEvent(event) {
    return event.target.closest(`[${this.attributes.muteToggle}]`);
  }

  getPlayerObjectFromEvent(event) {
    const container = event.target.closest(`[${this.attributes.container}]`);
    return this.players.find(player => player.container === container);
  }

  destroy() {
    this.players.forEach(playerObject => {
      const { player } = playerObject;
      player.destroy();
    });
  }
}
