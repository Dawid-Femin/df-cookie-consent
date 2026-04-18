(function () {
    'use strict';

    var COOKIE_NAME = dfcData.cookie_name;
    var COOKIE_DAYS = dfcData.cookie_days;

    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
    }

    function setCookie(name, value, days) {
        var expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/; SameSite=Lax';
    }

    function hideBanner() {
        var banner = document.getElementById('dfc-banner');
        if (banner) banner.classList.remove('dfc-visible');
    }

    function showBanner() {
        var banner = document.getElementById('dfc-banner');
        if (banner) banner.classList.add('dfc-visible');
    }

    function showIcon() {
        var icon = document.getElementById('dfc-icon');
        if (icon) icon.classList.add('dfc-visible');
    }

    function hideIcon() {
        var icon = document.getElementById('dfc-icon');
        if (icon) icon.classList.remove('dfc-visible');
    }

    function handleAccept() {
        setCookie(COOKIE_NAME, 'accepted', COOKIE_DAYS);
        hideBanner();
        showIcon();
    }

    function handleReject() {
        setCookie(COOKIE_NAME, 'rejected', COOKIE_DAYS);
        hideBanner();
        showIcon();
        disableButtons();
    }

    function buildBanner() {
        var banner = document.createElement('div');
        banner.id = 'dfc-banner';
        banner.setAttribute('role', 'dialog');
        banner.setAttribute('aria-label', 'Zgoda na pliki cookies');

        var links = '<a href="' + dfcData.cookies_url + '">Polityka cookies</a>' +
                    ' | <a href="' + dfcData.privacy_url + '">Polityka prywatności</a>' +
                    ' | <a href="' + dfcData.terms_url + '">Regulamin</a>' +
                    ' | <a href="' + dfcData.returns_url + '">Polityka zwrotów</a>';

        banner.innerHTML =
            '<div class="dfc-content">' +
                '<h3 class="dfc-title">' + dfcData.title + '</h3>' +
                '<p class="dfc-text">' + dfcData.text + '</p>' +
                '<p class="dfc-links">' + links + '</p>' +
                '<div class="dfc-buttons">' +
                    '<button id="dfc-reject" class="dfc-btn dfc-btn-reject">' + dfcData.reject_label + '</button>' +
                    '<button id="dfc-accept" class="dfc-btn dfc-btn-accept">' + dfcData.accept_label + '</button>' +
                '</div>' +
            '</div>';

        document.body.appendChild(banner);

        document.getElementById('dfc-accept').addEventListener('click', handleAccept);
        document.getElementById('dfc-reject').addEventListener('click', handleReject);
    }

    function buildIcon() {
        var icon = document.createElement('button');
        icon.id = 'dfc-icon';
        icon.setAttribute('aria-label', 'Zarządzaj zgodami na cookies');
        icon.title = 'Zarządzaj zgodami na cookies';
        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="22" height="22" fill="currentColor"><path d="M32 4C16.536 4 4 16.536 4 32s12.536 28 28 28 28-12.536 28-28c0-1.1-.064-2.185-.188-3.252a4 4 0 0 1-4.874-5.42A4 4 0 0 1 49.67 19.06a4 4 0 0 1-3.268-5.402A27.9 27.9 0 0 0 32 4zm-8 14a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm16 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm-20 8a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm18 4a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm-10 6a4 4 0 1 1 0 8 4 4 0 0 1 0-8zm-8 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm18 4a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg>';

        icon.addEventListener('click', function () {
            hideIcon();
            showBanner();
        });

        document.body.appendChild(icon);
    }

    var BLOCKED_TEXTS = ['umów spotkanie', 'kliknij tutaj', 'rezerwuję i płacę - 200,00 pln'];
    var TOOLTIP_MSG = 'Zaakceptuj cookies, aby kontynuować';

    function findBlockedButtons() {
        var all = document.querySelectorAll('a, button');
        return Array.prototype.filter.call(all, function (el) {
            var text = el.textContent.trim().toLowerCase();
            return BLOCKED_TEXTS.some(function (t) { return text.includes(t); });
        });
    }

    function disableButtons() {
        findBlockedButtons().forEach(function (el) {
            el.setAttribute('disabled', 'disabled');
            el.setAttribute('title', TOOLTIP_MSG);
            el.setAttribute('data-dfc-blocked', '1');
            el.style.opacity = '0.4';
            el.style.cursor = 'not-allowed';
            if (el.tagName === 'A') {
                el.dataset.dfcHref = el.getAttribute('href');
                el.setAttribute('href', 'javascript:void(0)');
            }
        });
    }

    function enableButtons() {
        var all = document.querySelectorAll('[data-dfc-blocked]');
        Array.prototype.forEach.call(all, function (el) {
            el.removeAttribute('disabled');
            el.removeAttribute('title');
            el.removeAttribute('data-dfc-blocked');
            el.style.opacity = '';
            el.style.cursor = '';
            if (el.tagName === 'A' && el.dataset.dfcHref) {
                el.setAttribute('href', el.dataset.dfcHref);
                delete el.dataset.dfcHref;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        buildBanner();
        buildIcon();

        var consent = getCookie(COOKIE_NAME);
        if (!consent) {
            showBanner();
            disableButtons();
        } else if (consent === 'rejected') {
            showIcon();
            disableButtons();
        } else {
            showIcon();
        }

        document.getElementById('dfc-accept').addEventListener('click', enableButtons);
    });
})();
