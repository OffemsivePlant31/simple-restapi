import '../scss/styles.scss'

const email = 'test@example.com';
const password = 'password';
const baseUrl = 'webserver/api';
const paths = {
  'login': '/login',
  'books': '/books',
  'genres': '/books/genres',
};
const filters = {};

let token = await getToken(baseUrl + paths['login'], email, password);
getGenres(baseUrl + paths['genres']);
updateData();

function updateFilter(column, value) {
  filters.page = null;
  filters[column] = value;
  updateData(filters);
}

const events = {
  'title': 'keyup',
  'author': 'keyup',
  'genre': 'change',
  'dateFrom': 'change',
  'dateTo': 'change',
  'sort': 'change',
};

Object.entries(events).forEach(([id, event]) => {
  document
    .querySelector(`#${id}`)
    .addEventListener(event, e => {
      if (e.target.type === 'select-multiple') {
        const values = [];
        e.target
          .querySelectorAll('option:checked')
          .forEach(option => values.push(option.value));
        updateFilter(id, values);
      } else {
        updateFilter(id, e.target.value);
      }
    });
});

async function getToken(url, email, password) {
  let response = await fetch(url, {
    method: 'post',
    headers: new Headers({
      'Content-Type': 'application/json'
    }),
    body: JSON.stringify({
      email,
      password
    })
  });
  let responseBody = await response.json();
  return responseBody.token;
}

async function getBooks(url, filters = {}) {
  let searchParams = new URLSearchParams(filters);
  let response = await fetch(`${url}?${searchParams.toString()}`, {
    headers: new Headers({
      'Authorization': 'Bearer ' + token
    })
  });
  let responseBody = await response.json();
  return responseBody;
}

async function getGenres(url) {
  let response = await fetch(url, {
    headers: new Headers({
      'Authorization': 'Bearer ' + token
    })
  });
  let genres = await response.json();
  console.log(genres);
  document.querySelector('#genre').append(...genres.map(genre => {
    const option = document.createElement('option');
    option.value = genre.id;
    option.innerText = genre.name;
    return option;
  }));
}

function updateView(selector, children) {
  document.querySelector(selector).replaceChildren(...children);
}

function createTableRows(books) {
  return books.map(book => {
    const tr = document.createElement('tr');
    Object.entries(book).forEach(([, value]) => {
      const td = document.createElement('th');
      td.innerHTML = value;
      tr.append(td);
    });
    return tr;
  });
}

function createPagination(totalCount, currentPage) {
  const pages = [];
  for (let i = 1; i <= totalCount; i++) {
    const li = document.createElement('li');
    li.classList.add('page-item');

    const a = document.createElement('a');
    a.classList.add('page-link');
    a.innerText = i;
    a.dataset.page = i;
    if (i === currentPage) {
      a.classList.add('active');
    }

    a.addEventListener('click', event => {
      event.preventDefault();
      updateData({ ...filters, page: event.target.dataset.page });
    });
    li.append(a);
    pages.push(li);
  }
  return pages;
}

async function updateData(filters = {}) {
  let { meta, data: books } = await getBooks(baseUrl + paths['books'], filters);
  updateView('.table tbody', createTableRows(books));
  updateView('.pagination', createPagination(meta.last_page, meta.current_page));
}
