import { reportConstants } from '../_constants';
import { reportService } from '../_services';

export const dateRangeActions = {
    dateChange,
    focusChange
};

const setFocusChange = data => ({
    type: "focusChange",
    payload: data,
});

const setDateChange = data => ({
    type: "dateChange",
    payload: data,
});

function dateChange(data) {
    return dispatch => {
        dispatch(setDateChange(data));
    };
}

function focusChange(data) {
    console.log(data);
    return dispatch => {
        dispatch(setFocusChange(data));
    };
}
