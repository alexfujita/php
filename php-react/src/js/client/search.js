import React, { Component, Fragment } from "react";
import { render } from "react-dom";
import axios from "axios";
import moment from "moment";
import "moment/locale/ja.js";
import { DatePicker, DatePickerInput } from "rc-datepicker";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faWindowClose,
  faCalendarAlt,
  faSearchLocation
} from "@fortawesome/free-solid-svg-icons";
import "../../sass/main.scss";
import { API_URL } from "../constants";
// import ModalClient from "../modalClient";
import Client from "./client";

export default class Search extends Component {
  constructor(props) {
    super(props);

    this.state = {
      names: "",
      range: "",
      mailAllowed: 0,
      tels: "",
      lastUsedYear: "",
      lastUsedMonth: "",
      lastUsedDay: "",
      lastUsedDate: "",
      lastUsedDayBeforeOrAfter: "",
      amount: "",
      amountLowerOrHigher: "",
      resultsTotal: 0,
      resultsFrom: 0,
      resultsTo: 0,
      results: [],
      visitedTimes: 0,
      visitedLowerOrHigher: "",
      id: null,
      showModalClient: false
    };

    this.handleChange = this.handleChange.bind(this);
    this.handleBlur = this.handleBlur.bind(this);
  }

  componentDidMount() {}

  handleChange(event) {
    const name = event.target.getAttribute("name");
    const value = event.target.value;
    this.setState({ [name]: value });
  }

  handleBlur(event) {
    const name = event.target.getAttribute("name");
    const value = event.target.value;
    this.setState({ [name]: value });
  }

  handleSearch(event) {
    event.preventDefault();
    let names, tels, lastUsedDate;
    if (this.state.names) {
      const namesArray = this.state.names.split("\n");
      const namesFiltered = namesArray.filter(n => n != "");
      names = namesFiltered.map(n => n.trim());
    }
    if (this.state.tels) {
      const telsArray = this.state.tels.split("\n");
      const telsFiltered = telsArray.filter(t => t != "");
      tels = telsFiltered.map(t => t.trim());
    }
    if (
      this.state.lastUsedYear &&
      this.state.lastUsedMonth &&
      this.state.lastUsedDay
    ) {
      lastUsedDate = `${this.state.lastUsedYear}-${this.state.lastUsedMonth}-${
        this.state.lastUsedDay
      }`;
    }
    const { range } = this.state;
    let dateFrom, dateTo, y;
    if (range === "2") {
      y = 20;
    } else if (range === "3") {
      y = 30;
    } else if (range === "4") {
      y = 40;
    } else if (range === "5") {
      y = 50;
    } else if (range === "6") {
      y = 60;
    } else if (range === "7") {
      y = 70;
    }
    dateTo = moment()
      .subtract(y, "years")
      .format("YYYY-MM-DD");

    dateFrom = moment()
      .subtract(y + 10, "years")
      .format("YYYY-MM-DD");
    axios
      .post(`${API_URL}search.php`, {
        names: names ? names : "",
        tels: tels ? tels : "",
        range: this.state.range,
        dateFrom,
        dateTo,
        mailAllowed: this.state.mailAllowed,
        lastUsedDate: lastUsedDate ? lastUsedDate : "",
        lastUsedDayBeforeOrAfter: this.state.lastUsedDayBeforeOrAfter,
        visitedTimes: this.state.visitedTimes,
        visitedLowerOrHigher: this.state.visitedLowerOrHigher,
        amount: this.state.amount,
        amountLowerOrHigher: this.state.amountLowerOrHigher
      })
      .then(response => {
        this.setState({
          results: response.data
        });
      })
      .catch(function(error) {
        console.log(error);
      });
  }

  handleClick(id) {
    this.setState({
      id: parseInt(id),
      showModalClient: true
    });
    console.log(id);
  }

  handleDownload(event) {
    event.preventDefault();
  }

  handleDismissModal() {
    console.log("dismissing modal...");
  }

  renderSearchHeader() {
    return (
      <form>
        <div className="row">
          <div className="col col50" style={{ alignItems: "flex-start" }}>
            <label>お客様氏名</label>
            {/* <div className="field"> */}
            <textarea
              name="names"
              value={this.state.names}
              onChange={this.handleChange}
              onBlur={this.handleBlur}
              rows="5"
            />
            {/* </div> */}
          </div>
          <div className="col col50" style={{ alignItems: "flex-start" }}>
            <label>電話番号</label>
            {/* <div className="field"> */}
            <textarea
              name="tels"
              value={this.state.tels}
              onChange={this.handleChange}
              onBlur={this.handleBlur}
              rows="5"
            />
            {/* </div> */}
          </div>
        </div>

        <div className="row">
          <div className="col col50">
            <label htmlFor="">年代</label>
            {/* <div className="field"> */}
            <select
              name="range"
              value={this.state.range}
              onChange={this.handleChange}
            >
              <option value="">選択</option>
              <option value="2">20代</option>
              <option value="3">30代</option>
              <option value="4">40代</option>
              <option value="5">50代</option>
              <option value="6">60代</option>
              <option value="7">70代</option>
            </select>
            {/* </div> */}
            <label htmlFor="">メルマガ配信可否</label>
            {/* <div className="field"> */}
            <select name="mailAllowed" onChange={this.handleChange}>
              <option value="">選択</option>
              <option value="0">不</option>
              <option value="1">可</option>
            </select>
            {/* </div> */}
          </div>

          <div className="col col50">
            <label htmlFor="">前回利用日</label>
            {/* <div className="field"> */}
            <input
              type="text"
              className="inputDate"
              name="lastUsedYear"
              value={this.state.lastUsedYear}
              onChange={this.handleChange}
            />
            <span>年</span>
            <input
              type="text"
              className="inputDate"
              name="lastUsedMonth"
              value={this.state.lastUsedMonth}
              onChange={this.handleChange}
            />
            <span>月</span>
            <input
              type="text"
              className="inputDate"
              name="lastUsedDay"
              value={this.state.lastUsedDay}
              onChange={this.handleChange}
            />
            <span>日</span>
            <select
              name="lastUsedDayBeforeOrAfter"
              value={this.state.beforeOrAfter}
              onChange={this.handleChange}
            >
              <option value="">選択</option>
              <option value="0">以前</option>
              <option value="1">以降</option>
            </select>
            {/* </div> */}
          </div>
        </div>

        <div className="row">
          <div className="col col50">
            <label htmlFor="">来店回数</label>
            {/* <div className="field"> */}
            <input
              type="text"
              name="visitedTimes"
              value={this.state.visitedTimes}
              onChange={this.handleChange}
            />
            <select
              name="visitedLowerOrHigherThan"
              value={this.state.visitedLowerOrHigherThan}
            >
              <option value="">選択</option>
              <option value="0">以下</option>
              <option value="1">以上</option>
            </select>
            {/* </div> */}
          </div>

          <div className="col col50">
            <label htmlFor="">清算金額</label>
            <input
              type="text"
              name="amount"
              value={this.state.amount}
              onChange={this.handleChange}
            />
            <select
              name="amountLlowerOrHigher"
              value={this.state.lowerOrHigher}
              onChange={this.handleChange}
            >
              <option value="">選択</option>
              <option value="0">以下</option>
              <option value="1">以上</option>
            </select>
          </div>
        </div>
        <div className="row m4-0">
          <div className="col" style={{ marginLeft: "auto" }}>
            <button
              className="btn btn__secondary"
              onClick={this.handleSearch.bind(this)}
            >
              上記条件で検索
            </button>
            <button
              className="btn btn__primary"
              style={{ marginLeft: "1rem" }}
              onClick={this.handleDownload.bind(this)}
            >
              ダウンロード（設定中）
            </button>
          </div>
        </div>
      </form>
    );
  }

  renderResultsBody() {
    this.state.results.map(r => {
      return (
        <tr>
          <td>
            {r.last_name} {r.first_name}
          </td>
          <td>{r.tel}</td>
          <td>{r.lastUsedDay}</td>
          <td>{r.range}</td>
          <td>{r.mailAllowed}</td>
          <td>{r.visitedTimes}</td>
          <td>{r.settlemenAmountTotal}</td>
        </tr>
      );
    });
  }

  renderSearchResults() {
    const { results } = this.state;

    if (results.length > 0) {
      return (
        <Fragment>
          <h4 className="results-title">
            該当件数：{results.length}件中 1件～
            {results.length}件を表示
          </h4>
          <table className="searchTable">
            <thead>
              <tr>
                <th>お客様氏名</th>
                <th>電話番号</th>
                <th>前回利用日</th>
                <th>年代</th>
                <th>メルマガ</th>
                <th>来店回数</th>
                <th>総清算金額</th>
              </tr>
            </thead>
            <tbody>
              {results.map(r => {
                const age = moment().diff(r.birthday, "years");
                let range;
                if (age >= 20 && age < 30) {
                  range = "20代";
                } else if (age >= 30 && age < 40) {
                  range = "30代";
                } else if (age >= 40 && age < 50) {
                  range = "40代";
                } else if (age >= 50 && age < 60) {
                  range = "50代";
                } else if (age >= 60 && age < 70) {
                  range = "60代";
                } else if (age >= 70 && age < 80) {
                  range = "70代";
                }

                return (
                  <tr key={`${r.id}`}>
                    <td onClick={this.handleClick.bind(this, r.id)}>
                      {r.last_name} {r.first_name}
                    </td>
                    <td>{r.phone}</td>
                    <td>確認中</td>
                    <td>{range}</td>
                    <td>確認中</td>
                    <td>確認中</td>
                    <td>確認中</td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </Fragment>
      );
    }
  }

  render() {
    if (!this.state.showModalClient) {
      return (
        <Fragment>
          {this.renderSearchHeader()}
          {this.renderSearchResults()}
        </Fragment>
      );
    } else if (this.state.showModalClient) {
      return (
        <Fragment>
          {this.state.showModalClient && <Client id={this.state.id} />}
        </Fragment>
      );
    }
    return (
      <Fragment>
        <div
          className="modal__content--footer"
          style={{ margin: "2rem -2rem -2rem -2rem" }}
        >
          <div className="modal__content--footer-buttons">
            <button
              className="btn"
              onClick={this.handleDismissModal.bind(this)}
            >
              閉じる（設定中）
            </button>
          </div>
          <div className="modal__content--footer-copyright">
            Copyright © Edge-Technology.ltd All Rights Reserved.
          </div>
        </div>
      </Fragment>
    );
  }
}

// render(<Search />, document.getElementById("search"));
