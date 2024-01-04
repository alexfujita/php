import React, { Component } from "react";
import { render } from "react-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faChevronRight } from "@fortawesome/free-solid-svg-icons";
import axios from "axios";
import { APP_URL } from "../constants";

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      loginId: "",
      password: "",
      error: false
    };
  }

  renderError() {
    return <p className="error">Error</p>;
  }

  handleAccountChange(event) {
    this.setState({
      loginId: event.target.value
    });
  }

  handlePasswordChange(event) {
    this.setState({
      password: event.target.value
    });
  }

  handleSubmit() {
    axios
      .post(`${APP_URL}auth/account.php`, {
        loginId: this.state.loginId,
        password: this.state.password
      })
      .then(response => {
        if (response.data === "sucess") {
          window.location.replace(`${APP_URL}calendar.php`);
        } else if (response.data === "blocked") {
          alert("3回パスワードを誤ったので、一定時間ログイン出来ません。");
        } else if (response.data === "failed") {
          alert("アカウントまたは、パスワードに誤りがあります。");
        }
      })
      .catch(function(error) {
        console.log(error);
      });
    this.setState({
      loginId: "",
      password: ""
    });
  }

  render() {
    return (
      <div className="container__login">
        <form className="login">
          <div className="logo">
            <img src="../src/img/logo.jpg" alt="" />
          </div>
          <div className="login__form">
            <h3>Login</h3>

            <div
              className="field"
              style={{ borderBottom: "1px solid #DCDCDC" }}
            >
              <label>Account ID</label>
              <input
                type="text"
                name="loginId"
                value={this.state.loginId}
                onChange={this.handleAccountChange.bind(this)}
              />
            </div>
            <div className="field">
              <label>Password</label>
              <input
                type="password"
                name="password"
                value={this.state.password}
                onChange={this.handlePasswordChange.bind(this)}
              />
            </div>
            <p>
              パスワード忘れた場合、<a>こちら</a>をクリックしてください
            </p>
          </div>
          {/* end login__form */}
          <button
            className="button__login"
            disabled={!this.state.loginId || !this.state.password}
            onClick={this.handleSubmit.bind(this)}
          >
            <FontAwesomeIcon icon={faChevronRight} size="4x" />
          </button>
        </form>
        {/* end login */}
      </div>
    );
  }
}

render(<Login />, document.getElementById("login"));
