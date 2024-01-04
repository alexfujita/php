import React, { Component } from "react";
import { render } from "react-dom";
import Form from "./client/form";
import FormView from "./client/formView";
import Search from "./client/search";
import Master from "./formMaster";
import FormClient from "./client/formClient";
import Success from "./components/Success";
import Failed from "./components/Failed";
import Alert from "./components/Alert";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";

export default class Modal extends Component {
  constructor(props) {
    super(props);
    this.state = {
      showModal: true,
      isFormView: false,
      isFormEdit: false,
      isFormClient: false,
      isFormMaster: false,
      sendStatus: "",
      showSvg: true,
      svgDismissed: false
    };
  }

  componentWillMount() {
    if (this.props.clientId) {
      this.setState({
        isFormView: true
      });
    } else if (this.props.scheduleDate) {
      this.setState({
        isFormEdit: true
      });
    } else if (this.props.master) {
      this.setState({
        isFormMaster: true
      });
    }
  }

  onDismiss() {
    this.setState({
      isFormEdit: false,
      isFormView: false,
      isFormMaster: false,
      showModal: false,
      success: false,
      failed: false,
      alert: false
    });
  }

  handleClickEdit() {
    this.setState({ isFormView: false, isFormEdit: true });
  }

  handleSendStatus() {}

  sendStatus(status) {
    this.setState({ sendStatus: status.sendStatus });
  }

  render() {
    const {
      isFormCreate,
      isFormEdit,
      isFormView,
      isFormClient,
      isFormMaster,
      showModal,
      sendStatus,
      showSvg,
      svgDismissed
    } = this.state;
    const { clientId, scheduleDate, master } = this.props;
    const showSendStatus = () => {
      if (this.state.sendStatus === "success") {
        return <Success />;
      } else if (this.state.sendStatus === "failed") {
        return <Failed />;
      }
    };

    const dismissSvg = () => {
      setTimeout(
        function() {
          this.setState({ showSvg: false, svgDismissed: true });
        }.bind(this),
        2000
      );
    };

    if (svgDismissed && this.state.sendStatus === "success") {
      setTimeout(
        function() {
          this.props.handleDismissModal(this);
          window.location.reload();
        }.bind(this),
        0
      );
    }

    // console.log(this.props);

    return (
      <div className="modal">
        <div className="modal__content">
          <div className="modal__content--header">
            <h2>
              {scheduleDate
                ? "引越情報登録"
                : isFormEdit
                ? "引越情報編集"
                : clientId
                ? "引越情報照会"
                : master && "マスター更新"}
            </h2>
            <FontAwesomeIcon
              icon={faWindowClose}
              size="2x"
              // onClick={this.onDismiss.bind(this)}
              onClick={this.props.handleDismissModal}
            />
          </div>

          <div className="modal__content--body">
            {isFormView ? (
              <FormView id={clientId} />
            ) : isFormEdit ? (
              <Form
                id={clientId}
                date={scheduleDate}
                sendStatus={this.sendStatus.bind(this)}
              />
            ) : (
              isFormMaster && <Master master={this.props.master} />
            )}
            {/* <Search /> */}
            {/* <FormClient /> */}
          </div>

          {isFormView && (
            <div className="modal__content--footer">
              <div className="modal__content--footer-buttons">
                {isFormView && (
                  <button onClick={this.handleClickEdit.bind(this)}>
                    編集
                  </button>
                )}
                {isFormView && (
                  <button
                    className="btn"
                    onClick={this.props.handleDismissModal}
                  >
                    閉じる
                  </button>
                )}
                {/* {isFormClient && (
								<button className="btn btn__primary" onClick={this.handleUpdate.bind(this)}>
									登録
								</button>
							)} */}
              </div>
              <div className="modal__content--footer-copyright">
                Copyright © Edge-Technology.ltd All Rights Reserved.
              </div>
            </div>
          )}
        </div>
        {showSvg && showSendStatus()}
        {showSvg && this.state.sendStatus !== "" && dismissSvg()}
      </div>
    );

    // }
  }
}

render(<Modal />, document.getElementById("formClient"));
