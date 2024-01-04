import React, { Component } from "react";
import { render } from "react-dom";
import axios from "axios";
import FormView from "./formView";
import Form from "./form";
import Calendar from "../calendar";
import Modal from "../modal";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";
import "../../sass/main.scss";

export default class ModalView extends Component {
  constructor(props) {
    super(props);
    this.state = {
      showModal: true,
      updateForm: false,
      createForm: false
    };
  }

  componentWillMount() {
    if (this.props.scheduleDate !== "") {
      this.setState({
        createForm: true,
        updateForm: false
      });
    } else if (this.props.cliendId !== 0) {
      this.setState({ createForm: false, updateForm: true });
    }
  }

  onDismiss() {
    this.setState({ showModal: false });
  }

  updateForm() {
    this.setState({
      updateForm: true
    });
  }
  render() {
    if (!this.state.showModal) {
      return <Calendar />;
    } else {
      return (
        <div className="modal">
          <div className="modal__content">
            <div className="modal__content--header">
              <h2>引越情報登録</h2>
              <FontAwesomeIcon
                icon={faWindowClose}
                size="2x"
                onClick={this.onDismiss.bind(this)}
              />
            </div>
            <div className="modal__content--body">
              {this.state.updateForm ? (
                <FormView id={this.props.clientId} />
              ) : (
                this.state.createForm && <Form date={this.props.scheduleDate} />
              )}
              <div className="row">
                <input
                  type="button"
                  value="更新"
                  onClick={this.updateForm.bind(this)}
                />
                <input
                  type="button"
                  value="閉じる"
                  onClick={this.onDismiss.bind(this)}
                />
              </div>
            </div>
          </div>
        </div>
      );
    }
  }
}
