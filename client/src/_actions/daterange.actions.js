
import { DateRangeConstants } from '../_constants';

export const dateRangeActions = {
    dateChange,
    focusChange,
    resetDatePicker
};

const setFocusChange = data => ({
    type: DateRangeConstants.FOCUS_CHANGE,
    payload: data,
});

const setDateChange = data => ({
    type: DateRangeConstants.DATE_CHANGE,
    payload: data,
});



const resetDateRange = () => ({
    type: DateRangeConstants.RESET_DATE_RANGE,
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
