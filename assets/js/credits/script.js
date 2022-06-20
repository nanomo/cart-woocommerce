(() => {
  const modal = document.querySelector('#mp-credits-modal')
  const modalContent = document.querySelector('.mp-credits-modal-container-content')
  const modalCentralize = document.querySelector('#mp-credits-centralize')

  const switchModal = () => {
    const actualStyle = modal.style.display
    if (actualStyle == 'block') {
      modal.style.display = 'none'
      modalContent.classList.remove('mp-mobile')
    }
    else {
      modal.style.display = 'block'
      modalCentralize.classList.add('mp-credits-modal-content-centralize')
      if (modal.clientWidth < 768) {
        modalCentralize.classList.remove('mp-credits-modal-content-centralize')
        const modalHeight = modal.clientHeight
        const modalContentHeight = modalContent.clientHeight
        modalContent.style.top = `${modalHeight - modalContentHeight}.px`
        modalContent.classList.add('mp-mobile')
      }
    }
  }

  const openBtn = document.querySelector('#mp-open-modal')
  openBtn.addEventListener('click', switchModal)
  const closebBtn = document.querySelector('#mp-credits-modal-close-modal')
  closebBtn.addEventListener('click', switchModal)

  window.onclick = function (event) {
    const modal = document.querySelector('.mp-credits-modal-container')
    if (event.target == modal) {
      switchModal()
    }
  }

  window.addEventListener('resize', () => {
    if (modal.clientWidth > 768) {
      modalCentralize.classList.add('mp-credits-modal-content-centralize')
      modalContent.classList.remove('mp-mobile')
    }else {
      modalCentralize.classList.remove('mp-credits-modal-content-centralize')
      modalContent.style.top = `${modal.clientHeight -  modalContent.clientHeight}.px`
      modalContent.classList.add('mp-mobile')
    }
  })

})()

