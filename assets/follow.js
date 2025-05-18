const boutons = document.querySelectorAll('.follow')

boutons.forEach((bouton)=>{
    bouton.addEventListener('click', follow)
})

function follow(event)
{
    event.preventDefault()

    fetch(this.href).then(response=>response.json())
        .then((data) =>{
            this.querySelector('.nbrFollow').innerHTML = data.count

            if(data.isFollow){
                this.querySelector('.person').classList.remove('bi-hand-thumbs-up', )
                this.querySelector('.person').classList.add('bi-hand-thumbs-up-fill', 'text-white')

            }else {
                this.querySelector('.person').classList.remove('bi-hand-thumbs-up-fill', 'text-white')
                this.querySelector('.person').classList.add('bi-hand-thumbs-up', 'text-black')

            }
        })
}