import '../styles/index.scss';

// frontend js file.
document.addEventListener('DOMContentLoaded', function () {
  const slider = document.getElementById("price-range");
  const range = document.getElementById("range-value");
  range.innerHTML = slider.value; // Display the default slider value

  // Update the current slider value (each time you drag the slider handle)
  slider.oninput = function() {
    range.innerHTML = this.value;
  }

  // Button click event binded on Search button.
  document.querySelector('button.search-btn').addEventListener('click', function(e) {
    e.preventDefault();
    const request = new XMLHttpRequest();
    const bookName = document.getElementById('book-name').value;
    const bookAuthor = document.getElementById('book-author').value;
    const bookPublisher = document.getElementById('book-publisher').value;
    const bookPrice = document.getElementById('price-range').value;
    const bookRating = document.getElementById('book-rating').value;
    const params = `_ajaxnonce=${ajaxload_params.nonce}&bookname=${bookName}&author=${bookAuthor}&publisher=${bookPublisher}&price=${bookPrice}&rating=${bookRating}`;
    request.open('POST', ajaxload_params.ajaxurl, true); //eslint-disable-line
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    request.onload = function ajaxLoad() {
      if (request.status >= 200 && request.status < 400) {
        const serverResponse = JSON.parse(request.responseText);
        const Obj = document.querySelector('.search-results tbody');
        Obj.innerHTML = serverResponse.data; // replace element with contents of serverResponse

        if (document.querySelectorAll('.search-results tbody tr').length > 10) {
          document.querySelector('button#load-more').style.display = 'block';
        } else {
          document.querySelector('button#load-more').style.display = 'none';
        }
      }
    };

    request.send(`action=search_books&${params}`); //eslint-disable-line
  });

  // Button click event binded on Load More button.
  document.querySelector('button#load-more').addEventListener('click', function(e) {
    const _ = jQuery;
    e.preventDefault();
    _('tr.hide').addClass('show');
    _('tr.hide').removeClass('hide');
    this.style.display = 'none';
  });
});
