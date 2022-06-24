(function () {
  let blueBadgeArr = document.querySelectorAll('.credits-info-example-buttons-child')
  let iconImg = document.querySelectorAll('.icon-image')
  let gifImg = document.querySelector('#gif-image')


  let btnFirst = document.querySelector('#btn-first')
  let btnSecond = document.querySelector('#btn-second')
  verify()


  function verify() {

      if (blueBadgeArr[0].classList.contains( 'selected')) {
          btnFirst.classList.add('credits-info-blue-color')
          btnSecond.classList.remove('credits-info-blue-color')
          iconImg[0].setAttribute('src', wc_mp_icon_images.computerBlueIcon)
          iconImg[1].setAttribute('src', wc_mp_icon_images.cellphoneGrayIcon)
          gifImg.setAttribute('src', wc_mp_icon_images.viewDesktop)
          return
      }
      if (blueBadgeArr[1].classList.contains('selected')) {
          btnSecond.classList.add('credits-info-blue-color')
          btnFirst.classList.remove('credits-info-blue-color')
          iconImg[1].setAttribute('src', wc_mp_icon_images.cellphoneBlueIcon)
          iconImg[0].setAttribute('src', wc_mp_icon_images.computerGrayIcon)
          gifImg.setAttribute('src', wc_mp_icon_images.viewMobile)
          return
      }
  }



  blueBadgeArr[0].addEventListener('click', () => {
      if (blueBadgeArr[0].classList.contains('selected')) {
          return
      } else {
          blueBadgeArr[0].classList.add('selected')
          blueBadgeArr[1].classList.remove('selected')

      }
      verify()
  })

  blueBadgeArr[1].addEventListener('click', () => {
      if (blueBadgeArr[1].classList.contains('selected')) {
          return
      } else {
          blueBadgeArr[1].classList.add('selected')
          blueBadgeArr[0].classList.remove('selected')
      }
      verify()
  })

})()
