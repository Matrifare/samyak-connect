# Samyak Matrimony - HTML Templates

This folder contains static HTML templates converted from the PHP files for easy reference and development.

## Files Included

| File | Description |
|------|-------------|
| `index.html` | Homepage with search form, features, and profile cards |
| `login.html` | Login page with username/password form |
| `register.html` | Registration form with all profile fields |
| `search.html` | Search page with filters and profile results |
| `view-profile.html` | Detailed profile view with tabs |
| `about-us.html` | About us page with features and testimonials |
| `contact.html` | Contact page with office addresses and form |

## Usage

1. Open any HTML file directly in a browser
2. All files use Bootstrap 5 CDN and Font Awesome for styling
3. Files are self-contained and work offline (except for CDN resources)

## Folder Structure

```
samyak-html/
├── index.html
├── login.html
├── register.html
├── search.html
├── view-profile.html
├── about-us.html
├── contact.html
├── README.md
└── assets/
    ├── css/
    │   └── style.css (custom styles)
    └── img/
        ├── logo.png
        ├── logo-white.png
        ├── default-male.png
        ├── default-female.png
        └── ... (other images)
```

## Technologies Used

- Bootstrap 5.3 (via CDN)
- Font Awesome 6.4 (via CDN)
- Google Fonts (Montserrat)

## Notes

- These are static HTML files with dummy data
- Forms submit to placeholder pages
- Replace CDN links with local files for production
- Add your own images to the assets/img folder

## Customization

1. **Colors**: Modify the Bootstrap primary color or add custom CSS in `assets/css/style.css`
2. **Content**: Edit the HTML directly to update text and images
3. **Forms**: Update form action URLs to point to your backend

## Original PHP Files Reference

| HTML File | Original PHP File |
|-----------|------------------|
| index.html | samyakonline/index.php |
| login.html | samyakonline/login.php |
| register.html | samyakonline/register.php |
| search.html | samyakonline/search.php |
| view-profile.html | samyakonline/view-profile.php |
| about-us.html | samyakonline/about-us.php |
| contact.html | samyakonline/contact_us.php |
