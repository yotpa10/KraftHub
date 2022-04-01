import React, { useState, useEffect, useRef } from "react";
import ReactDOM from 'react-dom';
import { Card, Button, Modal, Form } from "react-bootstrap";
import Wrapper from "./Wrapper";
import BookingsServiceAPI from "../../api/services/Bookings/BookingsService";
import * as dayjs from 'dayjs'
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


const ScheduledBooking = () => {
  const STATUS_ATTR = {
    pending: {color: 'text-warning', msg: "Pending"},
    done: {color: 'text-success', msg: "Done"},
    cancelled: {color: 'text-danger', msg: "Cancelled"},
    in_progress: {color: 'text-info', msg: "In Progress"},
  }
  const [show, setShow] = useState(false);
  const [scheduledBookings, setScheduledBookings] = useState(null);
  const [bookingState, setBookingState] = useState(null);
  const [bookingId, setBookingId] = useState(null);

  const handleClose = () => {
    setShow(false)
    setBookingState(null)
    setBookingId(null);
  };

  const handleShow = ({bookingId, status}) => {
    setShow(true)
    setBookingState(status)
    setBookingId(bookingId);
  };

  const loadScheduledBooking = () => {
    BookingsServiceAPI.getScheduled().then(({ results }) => {
      setScheduledBookings(results);
    })
  }

  const onChangeStatus = () => {
    BookingsServiceAPI.updateBookingStatus({
      id: bookingId,
      status: bookingState,
    }).then((data) => {
      toast.success(data.message);
      handleClose();
      loadScheduledBooking()
    })
  }

  useEffect(() => {
    loadScheduledBooking()
  }, []);

  return (
    <>
      <Wrapper>
        <Card className="mb-4">
          <Card.Body>
            <Card.Title>Scheduled Bookings</Card.Title>
            <table className="table table-responsive table-condensed table-striped table-hover">
              <thead>
                <tr>
                  <th>Maker</th>
                  <th>Status</th>
                  <th>Schedule</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                {
                  scheduledBookings && scheduledBookings.map(({
                    bookingId, first_name, last_name, status, eta, additional_info
                  }) => {
                    return (<tr>
                      <td>{first_name} {last_name}</td>
                      <td><span className={STATUS_ATTR[status].color}>{STATUS_ATTR[status].msg}</span></td>
                      <td>{dayjs(eta).format('MMMM DD, YYYY HH:mm')}</td>
                      <td>{additional_info}</td>
                      <td>
                        <div className="btn-group">
                          <Button onClick={() => handleShow({bookingId, status: "in_progress"})} variant="info" ><i className="fas fa-spinner"></i></Button>
                          <Button onClick={() => handleShow({bookingId, status: "done"})} variant="success" ><i className="fas fa-check"></i></Button>
                          <Button onClick={() => handleShow({bookingId, status: "cancelled"})} variant="danger" ><i className="fas fa-times"></i></Button>
                          <Button onClick={() => handleShow({bookingId, status: "pending"})} variant="warning" ><i className="fas fa-clock"></i></Button>
                        </div>
                      </td>
                    </tr>)
                  })
                }
                
              </tbody>
            </table>
          </Card.Body>
        </Card>
      </Wrapper>
      <BookingModal show={show} handleClose={handleClose} status={STATUS_ATTR?.[bookingState]?.msg} onChangeStatus={onChangeStatus} />
    </>
  );
};

const BookingModal = ({ show, handleClose, status, onChangeStatus }) => {
  return ReactDOM.createPortal(
    <>
      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>Booking Confirmation</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          Are you sure you want to set this booking to <b>{status}</b>
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            Close
          </Button>
          <Button variant="primary" onClick={() => onChangeStatus()}>
            Book now
          </Button>
        </Modal.Footer>
      </Modal>
      <ToastContainer />
    </>,
    document.getElementById('modal')
  );
}

export default ScheduledBooking;
