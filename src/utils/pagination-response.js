/**
 * Get paginated data.
 *
 * @param {Array}  items       Array of items.
 * @param {Number} currentPage Current page no.
 * @param {Number} perPage     Per page no.
 *
 * @returns {Object}           Paginated response.
 */
export function getPaginatedData(items, currentPage, perPage) {
    const totalItems = items.length;
    const totalPage  = Math.ceil(totalItems / perPage);
    const startIndex = perPage * (currentPage - 1);
    const endIndex   = startIndex + perPage;

    return {
        totalPage,
        totalItems,
        currentPage,
        perPage,
        data: items.filter((item, index) => {
            return index >= startIndex && index < endIndex;
        }),
    };
}
