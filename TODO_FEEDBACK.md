# TODO for Feedback: Make home.blade.php Post-Login Home Page

- [x] Create TODO_FEEDBACK.md
- [x] Edit routes/web.php: \n  - Update root '/' redirect to route('home') for auth users\n  - Replace /home redirect with HomeController@index middleware('auth')
- [x] php artisan route:clear
- [ ] Test: Login → root → /home → home.blade.php (with links to user.dashboard)
- [ ] Complete
