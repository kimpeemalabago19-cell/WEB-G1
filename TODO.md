# TODO

## Image Lightbox Modal (Admin Item Edit)
- [ ] Update `resources/views/admin/edit.blade.php`:
  - [ ] Add click target id + cursor style on the existing item image
  - [ ] Add isolated lightbox modal markup (overlay, centered image, close button)
  - [ ] Add scoped CSS for overlay + responsive sizing + no distortion
  - [ ] Add scoped JS to open modal on image click and close on:
    - [ ] close button
    - [ ] outside click (overlay)
    - [ ] ESC key
  - [ ] Prevent background scroll while modal is open
- [ ] Manual test in browser: `/admin/items/{id}/edit`

