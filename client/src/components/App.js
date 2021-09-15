import React from 'react';
import {connect} from 'react-redux';
import 'react-notifications/lib/notifications.css';
import {Container} from "react-bootstrap";
import {booking, dateRangeActions} from "../_actions";
import "../styles.css";
import {DateRangeInput} from "@datepicker-react/styled";
import {ThemeProvider} from "styled-components";
import moment from 'moment';


const ShowMessage = ({msg}) => {
    return (
        <div className={"messageHolder"}>
            <div className="message">{msg}</div>
        </div>
    )
};

function mapDispatchToProps(dispatch) {
    return {
        loadDashBoard: article => dispatch(booking.loadDashboard(article)),
        dateChangeFun: data => dispatch(dateRangeActions.dateChange(data)),
        focusChangeFun: focusInput => dispatch(dateRangeActions.focusChange(focusInput)),
        bookRoom: (data, callback) => dispatch(booking.bookRoom(data, callback)),
        checkAvailable: data => dispatch(booking.checkAvailable(data)),
        setMessage: data => dispatch(booking.setMessage(data)),
        resetDatePicker: data => dispatch(dateRangeActions.resetDatePicker(data))
    };
}

class App extends React.Component {
    constructor(props) {
        super(props);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);

        this.state = {
            firstname: "",
            lastname: "",
            email: "",
            errors: []
        };
    }

    handleInputChange(event) {
        let key = event.target.name;
        let value = event.target.value;
        let obj = {};
        obj[key] = value;
        this.setState(obj);
    }

    hasError(key) {
        return this.state.errors.indexOf(key) !== -1;
    }

    handleSubmit(event) {
        event.preventDefault();

        //VALIDATE
        var errors = [];

        //firstname
        if (this.state.firstname === "") {
            errors.push("firstname");
        }

        //lastname
        if (this.state.lastname === "") {
            errors.push("lastname");
        }

        //email
        const expression = /\S+@\S+/;
        var validEmail = expression.test(String(this.state.email).toLowerCase());

        if (!validEmail) {
            errors.push("email");
        }


        let startDate = moment(this.props.startDate).format('YYYY-MM-DD');
        let endDate = moment(this.props.endDate).format('YYYY-MM-DD');
        let reservation_date = [];

        for (let m = moment(startDate); m.isSameOrBefore(endDate); m.add(1, 'days')) {
            reservation_date.push(m.format('YYYY-MM-DD'));
        }

        if(reservation_date.length === 0){
            errors.push("daterange");
        }

        this.setState({
            errors: errors
        });

        if (errors.length > 0) {
            return false;
        } else {

            if (this.props.isAvailable) {
                this.props.bookRoom({
                    lastname: this.state.lastname,
                    firstname: this.state.firstname,
                    email: this.state.email,
                    reservation_date: reservation_date
                }, () => {
                    this.setState({
                        lastname: "",
                        firstname: "",
                        email: ""
                    });

                    this.props.resetDatePicker();
                    this.props.loadDashBoard();
                });


            } else {
                this.props.checkAvailable({
                    reservation_date: reservation_date
                });
            }

        }
    }

    componentDidMount() {
        this.props.loadDashBoard();
    }

    render() {

        let blockDates = [];
        this.props.reservations.map((data) => {
            blockDates.push(new Date(data.reservation_date))
        });

        let mesg = "";

        if (this.props.message !== "") {

            setTimeout(() => {
                this.props.setMessage("")
            }, 5000);

            mesg = <ShowMessage msg={this.props.message}/>
        }
        return (
            <div className='App'>

                <Container fluid="md">

                    {mesg}

                    <form ref={form => this.form = form} className="row">
                        <div className="col-lg-6 mt-2">
                            <ThemeProvider
                                theme={{
                                    reactDatepicker: {
                                        datepickerZIndex: 100000
                                    }
                                }}
                            >
                                <DateRangeInput
                                    onDatesChange={data => this.props.dateChangeFun(data)}
                                    onFocusChange={focusedInput => this.props.focusChangeFun(focusedInput)}
                                    startDate={this.props.startDate} // Date or null
                                    endDate={this.props.endDate} // Date or null
                                    focusedInput={this.props.focusedInput} // START_DATE, END_DATE or null
                                    unavailableDates={blockDates}
                                    minBookingDate={new Date()}
                                    maxBookingDate={moment().add(1, 'years').toDate()}
                                    startDateInputId={"start_date"}
                                    endDateInputId={"end_date"}
                                />

                            </ThemeProvider>

                            <div
                                className={
                                    this.hasError("daterange") ? "inline-errormsg" : "hidden"
                                }
                            >
                                Please select Start date and end date time
                            </div>
                        </div>

                        <div className="col-lg-6 mt-2">
                            <input
                                autoComplete="off"
                                className={
                                    this.hasError("firstname")
                                        ? "form-control is-invalid custom-input"
                                        : "form-control custom-input"
                                }
                                name="firstname"
                                value={this.state.firstname}
                                placeholder={"First name"}
                                onChange={this.handleInputChange}
                            />
                            <div
                                className={
                                    this.hasError("firstname") ? "inline-errormsg" : "hidden"
                                }
                            >
                                Please enter a value
                            </div>
                        </div>

                        <div className="col-lg-6 mt-2">
                            <input
                                autoComplete="off"
                                className={
                                    this.hasError("lastname")
                                        ? "form-control is-invalid custom-input"
                                        : "form-control custom-input"
                                }
                                name="lastname"
                                placeholder={"Last name"}
                                value={this.state.lastname}
                                onChange={this.handleInputChange}
                            />
                            <div
                                className={
                                    this.hasError("lastname") ? "inline-errormsg" : "hidden"
                                }
                            >
                                Please enter a value
                            </div>
                        </div>

                        <div className="col-lg-6 mt-2">
                            <input
                                autoComplete="off"
                                className={
                                    this.hasError("email")
                                        ? "form-control is-invalid custom-input"
                                        : "form-control custom-input"
                                }
                                name="email"
                                value={this.state.email}
                                placeholder={"Email"}
                                onChange={this.handleInputChange}
                            />
                            <div
                                className={this.hasError("email") ? "inline-errormsg" : "hidden"}
                            >
                                Email is invalid or missing
                            </div>
                        </div>

                        <div className="col-lg-12  padd-top mt-3 " >
                            <button className="btn btn-submit p-3" onClick={this.handleSubmit}>
                                {this.props.buttonText}
                            </button>
                        </div>
                    </form>
                </Container>
            </div>

        );
    }
}


function mapStateToProps(state) {
    const {loading} = state.booking;
    const {startDate} = state.daterange;
    const {endDate} = state.daterange;
    const {focusedInput} = state.daterange;
    const {reservations} = state.booking;
    const {isAvailable, buttonText, message} = state.booking;
    return {
        loading,
        reservations,
        startDate,
        endDate,
        focusedInput,
        isAvailable,
        buttonText,
        message
    };
}

const connectedApp = connect(mapStateToProps, mapDispatchToProps)(App);
export {connectedApp as App};
