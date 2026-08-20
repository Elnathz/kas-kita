const test = require('node:test');
const assert = require('node:assert/strict');

const {
    MAX_FILE_SIZE,
    isTooLarge,
} = require('../../public/assets/js/upload-validation.js');

test('menerima file dengan ukuran tepat 2 MB', () => {
    assert.equal(isTooLarge({ size: MAX_FILE_SIZE }), false);
});

test('menolak file yang ukurannya lebih dari 2 MB', () => {
    assert.equal(isTooLarge({ size: MAX_FILE_SIZE + 1 }), true);
});

test('menganggap file kosong sebagai ukuran yang valid', () => {
    assert.equal(isTooLarge(null), false);
});
