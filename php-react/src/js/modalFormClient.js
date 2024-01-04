import React, { Component } from "react";
import { render } from "react-dom";
import FormClient from "./client/formClient";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";

export default class ModalFormClient extends Component {
  constructor(props) {
    super(props);
    this.state = {
      showModal: true
    };
  }

  componentWillMount() {}

  onDismiss() {
    this.setState({
      showModal: false
    });
  }

  render() {
    const { showModal } = this.state;

    return (
      <div className="modal">
        <div className="modal__content">
          <div className="modal__content--header">
            <h2>顧客登録</h2>
            <FontAwesomeIcon
              icon={faWindowClose}
              size="2x"
              onClick={this.props.handleDismissModal}
            />
          </div>

          <div className="modal__content--body">
            <FormClient />
          </div>
        </div>
      </div>
    );
  }
}

render(<ModalFormClient />, document.getElementById("formClient"));
