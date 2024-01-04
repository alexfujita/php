import React, { Component } from "react";
import { render } from "react-dom";
import Client from "./client/client";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";

export default class ModalClient extends Component {
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
            <h2>顧客参照</h2>
            <FontAwesomeIcon
              icon={faWindowClose}
              size="2x"
              onClick={this.props.handleDismissModal}
            />
          </div>

          <div className="modal__content--body">
            <Client />}
          </div>
        </div>
      </div>
    );
  }
}
