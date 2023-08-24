/**
* Main Javascript
*/

$(window).resize(function() {
  if($(window).width() < 992) {
      $('.flex-remove-md').removeClass('d-flex');
  } else {
      $('.flex-remove-md').removeClass('d-flex').addClass('d-flex');
  }
});

const confirmDelete = (message) => {
  Swal.fire({
      title: 'Are you sure?',
      icon: 'info',
      text: message,
      showCancelButton: true,
      cancelButtonColor: '#666',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#d9534f',
      confirmButtonText: "Delete"
      }).then((result) => {
      if(result.isConfirmed) {
          return true;  
      } else { return false; }
  });
};

$(document).ready(function(){

  $('.btn-warn').click(function(e){
      e.preventDefault();
      var url = $(this).attr('href');
      Swal.fire({
          title: 'Are you sure?',
          icon: 'info',
          text: $(this).attr('data-warning'),
          showCancelButton: true,
          cancelButtonColor: '#666',
          cancelButtonText: 'Cancel',
          confirmButtonColor: '#0d6efd',
          confirmButtonText: "Continue"
          }).then((result) => {
          if(!result.isConfirmed) {
              return false;
          }
          return window.location.href = url;
      })
  });

  // window size
  if($(window).width() < 992) {
      $('.flex-remove-md').removeClass('d-flex');
  } else {
      $('.flex-remove-md').removeClass('d-flex').addClass('d-flex');
  }
});

(function() {
  "use strict";

  // Easy selector helper function
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  // Easy event listener function
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  // Easy on scroll event listener 
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  // Navbar links active state on scroll
  let navbarlinks = select('#theme-navbar .nav-link', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  // Scrolls to an element with header offset
  const scrollto = (el) => {
    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos,
      behavior: 'smooth'
    })
  }

  // Back to top button
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  // Mobile nav toggle
  on('click', '.mobile-nav-toggle', function(e) {
    select('body').classList.toggle('mobile-nav-active')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  // Scrol with ofset on links with a class name .scrollto
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      let body = select('body')
      if (body.classList.contains('mobile-nav-active')) {
        body.classList.remove('mobile-nav-active')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  // Scroll with ofset on page load with hash links in the url
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });
  

})()