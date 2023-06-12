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