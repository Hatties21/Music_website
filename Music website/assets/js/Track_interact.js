document.addEventListener('DOMContentLoaded', function() {
    const audioPlayer = document.getElementById('audioPlayer');
    const audioSource = document.getElementById('audioSource');
    const fileInput = document.getElementById('fileInput');
    const playButton = document.getElementById('playButton');
    const pauseButton = document.getElementById('pauseButton');
  
    fileInput.addEventListener('change', function() {
      const file = this.files[0];
      const objectURL = URL.createObjectURL(file);
      audioSource.src = objectURL;
      audioPlayer.load(); // Reload audio player with new source
    });
  
    playButton.addEventListener('click', function() {
      audioPlayer.play();
    });
  
    pauseButton.addEventListener('click', function() {
      audioPlayer.pause();
    });
  });