import "babel-polyfill";
import React, { Component, Fragment } from "react";
import { render } from "react-dom";
import axios from "axios";
import moment from "moment";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faChevronLeft,
  faChevronRight,
  faCalendarPlus,
  faBars
} from "@fortawesome/free-solid-svg-icons";
import Modal from "./modal";
import { API_URL } from "./constants";

export default class Calendar extends Component {
  constructor(props) {
    super(props);
    moment.locale("ja");

    this.state = {
      dateObj: moment(),
      currentYear: moment(),
      currentMonth: moment(),
      clients: [],
      clientId: null,
      showModal: false,
      newSchedule: false,
      scheduleDate: null,
      showMenu: false,
      master: ""
    };
  }

  fetchClients() {
    const startOfMonth = this.state.currentMonth
      .startOf("month")
      .format("YYYY-MM-DD");
    const endOfMonth = this.state.currentMonth
      .endOf("month")
      .format("YYYY-MM-DD");
    axios
      .post(`${API_URL}fetchMovings.php`, {
        startOfMonth,
        endOfMonth
      })
      .then(response => {
        this.setState({ clients: response.data });
      })
      .catch(function (error) {
        console.log(error);
      });
  }

  componentDidMount() {
    this.fetchClients();
    this.state.clients;
  }

  addSchedule(fullDate) {
    this.setState({
      showModal: true,
      newSchedule: true,
      scheduleDate: fullDate
    });
  }

  nextMonth() {
    this.setState({
      currentMonth: this.state.currentMonth.add(1, "months")
    });
    this.fetchClients();
  }
  prevMonth() {
    this.setState({
      currentMonth: this.state.currentMonth.subtract(1, "months")
    });
    this.fetchClients();
  }

  toggleMenu() {
    this.setState({
      showMenu: !this.state.showMenu
    });
  }

  renderHeader() {
    let currentMonth = this.state.currentMonth.format("M月");
    let currentYear = this.state.currentMonth.format("YYYY年");
    return (
      <div className="calendar__header">
        <div>
          <FontAwesomeIcon
            icon={faChevronLeft}
            size="2x"
            onClick={this.prevMonth.bind(this)}
            style={{ marginRight: "2rem", cursor: "pointer" }}
          />
          <FontAwesomeIcon
            icon={faChevronRight}
            size="2x"
            onClick={this.nextMonth.bind(this)}
            style={{ cursor: "pointer" }}
          />
        </div>

        <h2>
          {currentYear}
          {currentMonth}
        </h2>
        <div style={{ position: "relative" }}>
          <FontAwesomeIcon
            icon={faBars}
            size="3x"
            onClick={this.toggleMenu.bind(this)}
          />

          {this.state.showMenu && (
            <div className="menu">
              <ul>
                <li>CSVファイル出力</li>
                <li onClick={this.handleClickMaster.bind(this)}>
                  マスター更新
                </li>
                <li>前月締め処理</li>
                <li>月次レポート出力</li>
                <li>支払通知書出力</li>
                <li>振込データ作成</li>
              </ul>
            </div>
          )}
        </div>
      </div>
    );
  }

  renderWeekdays() {
    return moment.weekdays(true).map(weekday => {
      return (
        <span key={weekday} className="weekday">
          {weekday}
        </span>
      );
    });
  }

  firstDayOfMonth() {
    let dateContext = this.state.dateContext;
    let firstDay = this.state.currentMonth.startOf("month").format("d"); // Day of week 0...1..5...6
    return firstDay;
  }

  handleClickClient(data) {
    this.setState({
      clientId: parseInt(data),
      showModal: true
    });
  }

  handleClickMaster() {
    this.setState({
      master: "formCreate",
      showMenu: false,
      showModal: true
    });
  }

  renderDays() {
    const { currentMonth, clients } = this.state;
    const rows = [];
    let days = [];
    let startDays = [];
    let endDays = [];

    for (let i = 0; i < this.firstDayOfMonth(); i++) {
      startDays.push(
        <div key={i * 80} className="empty">
          {""}
        </div>
      );
    }

    let daysInMonth = [];
    for (let d = 0; d < currentMonth.daysInMonth(); d++) {
      const yearMonth = currentMonth.format("YYYY-MM");
      const dStr = d.toString().length === 1 ? "0" + (d + 1) : d + 1;
      const fullDate = `${yearMonth}-${dStr}`;
      days.push(
        <Fragment key={d}>
          <div
            className="day__header"
            style={{
              display: "flex",
              alignItems: "center",
              justifyContent: "space-between"
            }}
          >
            <span>{d + 1}</span>
            <FontAwesomeIcon
              icon={faCalendarPlus}
              size="lg"
              color="#C0C0C0"
              onClick={this.addSchedule.bind(this, fullDate)}
            />
          </div>
          <div className="day__body">
            {clients
              .filter(client => client.moving_date.substring(8) == d + 1)
              .map(client => (
                <div
                  key={client.id}
                  className="client__link"
                  onClick={this.handleClickClient.bind(this, client.id)}
                >
                  {client.last_name} {client.first_name}
                </div>
              ))}
          </div>
        </Fragment>
      );
    }

    var daysCells = [...startDays, ...days];
    let totalCellsLength = 0;
    if (this.firstDayOfMonth() > 4 && currentMonth.daysInMonth() > 30) {
      totalCellsLength = 42;
    } else if (
      this.firstDayOfMonth() == 0 &&
      currentMonth.daysInMonth() == 28
    ) {
      totalCellsLength = 28;
    } else {
      totalCellsLength = 35;
    }
    const endDaysLength = totalCellsLength - daysCells.length;

    for (let ed = 0; ed < endDaysLength; ed++) {
      endDays.push(
        <div key={ed * 100} className="empty">
          {""}
        </div>
      );
    }
    var totalCells = [...daysCells, ...endDays];
    let spanElems = totalCells.map((d, i) => {
      return (
        <div className="day" key={i * 100}>
          {d}
        </div>
      );
    });

    return spanElems;
  }

  handleDismissModal() {
    this.setState({
      showModal: false,
      clientId: null,
      scheduleDate: null
    });
  }

  render() {
    // console.log(this.state.clients);
    const { clientId, scheduleDate } = this.state;
    return (
      <Fragment>
        <h2>引越予定カレンダー</h2>
        <div className="calendar">
          {this.renderHeader()}
          <div className="weekdays">{this.renderWeekdays()}</div>
          <div className="days">{this.renderDays()}</div>
        </div>
        {this.state.showModal && (
          <Modal
            clientId={clientId}
            scheduleDate={this.state.scheduleDate}
            master={this.state.master}
            handleDismissModal={this.handleDismissModal.bind(this)}
          />
        )}
      </Fragment>
    );
  }
}

render(<Calendar />, document.getElementById("calendar"));
