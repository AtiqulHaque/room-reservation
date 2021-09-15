export const dateRangeActions = {
    dateChange,
    focusChange,
    resetDatePicker
};

const setFocusChange = data => ({
    type: "focusChange",
    payload: data,
});

const setDateChange = data => ({
    type: "dateChange",
    payload: data,
});



const resetDateRange = () => ({
    type: "resetDateRange",
    payload: {},
});

function dateChange(data) {
    return dispatch => {
        dispatch(setDateChange(data));
    };
}

function focusChange(data) {
    return dispatch => {
        dispatch(setFocusChange(data));
    };
}

function resetDatePicker() {
    return dispatch => {
        dispatch(resetDateRange());
    };
}
