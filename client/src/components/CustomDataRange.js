import React, {useReducer} from 'react'
import {DateRangeInput} from '@datepicker-react/styled'


function App() {
    const [state, dispatch] = useReducer(reducer, initialState)
    console.log(state);
    return (
        <DateRangeInput
            onDatesChange={data => dispatch({type: 'dateChange', payload: data})}
            onFocusChange={focusedInput => dispatch({type: 'focusChange', payload: focusedInput})}
            startDate={state.startDate} // Date or null
            endDate={state.endDate} // Date or null
            focusedInput={state.focusedInput} // START_DATE, END_DATE or null
        />
    )
}
