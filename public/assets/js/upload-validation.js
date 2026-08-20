(function (root, factory) {
    const api = factory();

    if (typeof module === 'object' && module.exports) {
        module.exports = api;
    } else {
        root.KasKitaUploadValidation = api;
    }
})(typeof globalThis !== 'undefined' ? globalThis : this, function () {
    const MAX_FILE_SIZE = 2 * 1024 * 1024;

    function isTooLarge(file, maxBytes = MAX_FILE_SIZE) {
        return Boolean(file && Number(file.size) > maxBytes);
    }

    return {
        MAX_FILE_SIZE,
        isTooLarge,
    };
});
