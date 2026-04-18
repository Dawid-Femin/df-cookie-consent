# DF Cookie Consent

Prosty plugin WordPress z banerem zgody na pliki cookies zgodnym z RODO, stworzony dla strony wizytówki psychologa.

## Funkcje

- Baner w prawym dolnym rogu (desktop) / pełnoekranowy bottom sheet (mobile)
- Przyciski: **Akceptuj wszystkie** i **Odrzuć**
- Zgoda zapisywana w cookie na 365 dni
- Ikonka w lewym dolnym rogu do ponownego otwarcia banera
- Linki do: polityki prywatności, polityki cookies, regulaminu, polityki zwrotów
- Panel ustawień w WP Admin → Ustawienia → Cookie Consent

## Instalacja

1. Skopiuj katalog `df-cookie-consent` do `wp-content/plugins/`
2. Aktywuj plugin w WP Admin → Wtyczki
3. Skonfiguruj treść i linki w WP Admin → Ustawienia → Cookie Consent

## Dostosowanie stylów

Edytuj `assets/css/cookie-consent.css`. Kluczowe zmienne do zmiany:
- Kolor przycisku akceptacji: `.pcc-btn-accept { background: #4f46e5; }`
- Kolor ikonki: `#pcc-icon { background: #4f46e5; }`
- Breakpoint mobile: `@media (max-width: 480px)`

## Struktura plików

```
df-cookie-consent/
├── df-cookie-consent.php   # Główny plik pluginu
├── admin/
│   └── settings.php               # Panel ustawień WP Admin
├── assets/
│   ├── css/
│   │   └── cookie-consent.css     # Style banera i ikonki
│   └── js/
│       └── cookie-consent.js      # Logika banera
├── .gitignore
└── README.md
```
