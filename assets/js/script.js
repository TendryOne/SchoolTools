const profile = document.querySelector('.profile')
let drop = document.querySelector('.dropdown-profile')


profile.addEventListener('click' , e =>{
    if(!drop.classList.contains('active')){
        drop.classList.add('active')
    }
    else{
        drop.classList.remove('active')
    }
})


function displayFileName(input) {
    let fileNameElement = document.getElementById('fileName');
    fileNameElement.textContent = input.files[0].name;
  }
  
  function displayImagePreview(input) {
    let fileLabel = document.getElementById('fileLabel');
    let file = input.files[0];
  
    if (file) {
      var reader = new FileReader();
  
      reader.onload = function(event) {
        fileLabel.style.backgroundImage = 'url(' + event.target.result + ')';
      };
  
      reader.readAsDataURL(file);
    } else {
      fileLabel.style.backgroundImage = '';
    }
  }
  
