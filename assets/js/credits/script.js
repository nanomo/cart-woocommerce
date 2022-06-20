(() => {
  const switchModal = () => {
    const modal = document.querySelector('#mp-credits-modal')
    const actualStyle = modal.style.display
    const modalContent = document.querySelector('.mp-credits-modal-container-content')


    if (actualStyle == 'block') {
      modal.style.display = 'none'
      modalContent.classList.remove('mp-mobile')
    }
    else {
      modal.style.display = 'block'
      if (modal.clientWidth < 666) {
        const modalHeight = modal.clientHeight
        const modalContentHeight = modalContent.clientHeight
        let top = modalHeight - modalContentHeight
        modalContent.style.top = `${top}.px`
        modalContent.classList.add('mp-mobile')
      }
    }
  }

  const openBtn = document.querySelector('#mp-open-modal')
  openBtn.addEventListener('click', switchModal)
  const closebBtn = document.querySelector('#mp-credits-modal-close-modal')
  closebBtn.addEventListener('click', switchModal)

  window.onclick = function (event) {
    console.log(event)
    const modal = document.querySelector('.mp-credits-modal-container')
    if (event.target == modal) {
      switchModal()
    }
  }
})()
