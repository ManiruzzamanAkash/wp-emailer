/**
 * Internal dependencies.
 */
const $ = jQuery;

/**
 * Get AJAX request.
 *
 * @param {String} params Request params.
 * @returns Promise
 */
export async function getRequest(params) {
    const url = `${wpEmailer.ajax_url}?_wpnonce=${wpEmailer.nonce}&${params}`;

    return $.ajax({
        url,
        type       : "GET",
        processData: false,
        contentType: false,
    });
}

/**
 * Post AJAX request.
 *
 * @param {Object} body Post object
 * @returns Promise
 */
export async function postRequest(body) {
    const postData = {
        _wpnonce: wpEmailer.nonce,
        ...body
    };

    return $.ajax({
        type       : "POST",
        url        : wpEmailer.ajax_url,
        data       : generateFormDataFromObject(postData),
        processData: false,
        contentType: false,
    });
}

/**
 * Generate Form Data from Object
 *
 * @param object object data
 *
 * @return Object FormData Object
 */
const generateFormDataFromObject = (object) => {
    let formData = new FormData();
    buildFormData(formData, object);
    return formData;
};

const buildFormData = (formData, data, parentKey) => {
    if (data && typeof data === 'object'
        && !(data instanceof Date)
        && !(data instanceof File)
    ) {
        Object.keys(data).forEach(key => {
            buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
        });
    } else {
        let value = data == null ? '' : data;
        formData.append(parentKey, value);
    }
};
