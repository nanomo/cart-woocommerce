const switchModal = () => {
    const modal = document.querySelector('#mp-credits-modal')
    const actualStyle = modal.style.display
    console.log(actualStyle )
    if(actualStyle == 'block') {
      modal.style.display = 'none'
    }
    else {
      modal.style.display = 'block'
    }
  }
  
  const openBtn = document.querySelector('#mp-open-modal')
  openBtn.addEventListener('click', switchModal)
  const closebBtn = document.querySelector('#mp-credits-modal-close-modal')
  closebBtn.addEventListener('click', switchModal)
  
  console.log(openBtn)
  console.log(closebBtn)