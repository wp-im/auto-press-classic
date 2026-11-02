(function () {
  const body = document.body;
  const header = document.querySelector('.ap-site-header');
  const navigation = document.querySelector('#site-navigation');
  const menuButton = document.querySelector('.ap-menu-toggle');
  const backdrop = document.querySelector('.ap-menu-backdrop');
  const searchButton = document.querySelector('.ap-search-toggle');
  const searchPanel = document.querySelector('#header-search');
  const mobile = window.matchMedia('(max-width: 1100px)');
  const background = Array.from(document.querySelectorAll('main, .ap-site-footer, .ap-brand, #wpadminbar'));
  const initialInert = new Map(background.map(element => [element, element.inert]));

  function positionDrawer() {
    if (!header) return;
    body.style.setProperty('--ap-drawer-top', Math.max(0, header.getBoundingClientRect().bottom) + 'px');
  }

  function setMenu(open, returnFocus) {
    if (!menuButton || !navigation) return;
    open = open && mobile.matches;
    positionDrawer();
    body.classList.toggle('ap-menu-open', open);
    menuButton.setAttribute('aria-expanded', String(open));
    navigation.inert = mobile.matches && !open;
    background.forEach(element => { element.inert = open || initialInert.get(element); });
    if (searchButton) searchButton.inert = open;
    if (open) {
      const first = navigation.querySelector('a[href]');
      if (first) first.focus();
    } else if (returnFocus) {
      menuButton.focus();
    }
  }

  function setSearch(open, returnFocus) {
    if (!searchButton || !searchPanel) return;
    body.classList.toggle('ap-search-open', open);
    searchButton.setAttribute('aria-expanded', String(open));
    searchPanel.setAttribute('aria-hidden', String(!open));
    searchPanel.inert = !open;
    if (open) {
      const input = searchPanel.querySelector('input[type="search"]');
      if (input) input.focus();
    } else if (returnFocus) {
      searchButton.focus();
    }
  }

  if (menuButton) menuButton.addEventListener('click', function () {
    setSearch(false);
    setMenu(!body.classList.contains('ap-menu-open'), true);
  });
  if (backdrop) backdrop.addEventListener('click', function () { setMenu(false, true); });
  if (navigation) navigation.addEventListener('click', function (event) {
    if (event.target.closest('a')) setMenu(false);
  });
  if (searchButton) searchButton.addEventListener('click', function () {
    setMenu(false);
    setSearch(!body.classList.contains('ap-search-open'), true);
  });
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      if (body.classList.contains('ap-menu-open')) setMenu(false, true);
      if (body.classList.contains('ap-search-open')) setSearch(false, true);
    }
    if (event.key === 'Tab' && body.classList.contains('ap-menu-open')) {
      const controls = [menuButton].concat(Array.from(navigation.querySelectorAll('a[href]')));
      const current = controls.indexOf(document.activeElement);
      const next = (current + (event.shiftKey ? -1 : 1) + controls.length) % controls.length;
      event.preventDefault();
      controls[next].focus();
    }
  });
  mobile.addEventListener('change', function () { setMenu(false); });
  window.addEventListener('resize', positionDrawer);
  window.addEventListener('scroll', positionDrawer, { passive: true });
  setSearch(false);
  setMenu(false);
})();
