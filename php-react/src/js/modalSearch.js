import React, { Component } from "react";
import { render } from "react-dom";
import Search from "./client/search";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";

export default class ModalSearch extends Component {
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
            <h2>顧客検索</h2>
            <FontAwesomeIcon
              icon={faWindowClose}
              size="2x"
              onClick={this.props.handleDismissModal}
            />
          </div>

          <div className="modal__content--body">
            <Search />
          </div>
        </div>
      </div>
    );
  }
}

render(<ModalSearch />, document.getElementById("search"));
