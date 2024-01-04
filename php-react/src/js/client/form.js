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

export default class Form extends Component {
  constructor(props) {
    super(props);

    this.state = {
      id: 0,
      lastName: "",
      firstName: "",
      lastNameKana: "",
      firstNameKana: "",
      genre: 0,
      birthYear: "",
      birthMonth: "",
      birthDay: "",
      birthDate: "",
      email: "",
      tel1: "",
      tel1L: "",
      tel1C: "",
      tel1R: "",
      tel2: "",
      tel2L: "",
      tel2C: "",
      tel2R: "",
      carrier: "",
      contactable: 0,
      contactableYear1: "",
      contactableMonth1: "",
      contactableDay1: "",
      contactableTimeFrom1: "",
      contactableTimeTo1: "",
      contactableDate1: "",
      contactableYear2: "",
      contactableMonth2: "",
      contactableDay2: "",
      contactableDate2: "",
      contactableTimeFrom2: "",
      contactableTimeTo2: "",
      actualPostalCodePrefix: "",
      actualPostalCodeSufix: "",
      actualPostalCode: "",
      actualAddress1: "",
      actualAddress2: "",
      actualAddress3: "",
      actualAddress4: "",
      actualInfra: 0,
      movingYear: "",
      movingMonth: "",
      movingDay: "",
      movingDate: "",
      movingPostalCodePrefix: "",
      movingPostalCodeSufix: "",
      movingPostalCode: "",
      movingAddress1: "",
      movingAddress2: "",
      movingAddress3: "",
      movingAddress4: "",
      electrical: false,
      internet: false,
      cityGas: false,
      oaEquipment: false,
      propaneGas: false,
      hpSecurity: false,
      water: false,
      waterServer: false,
      electricalStatus: 0,
      gasStatus: 0,
      internetStatus: 0,
      homeSecurityStatus: 0,
      memo: "",
      showBdPicker: false,
      showC1Picker: false,
      showC2Picker: false,
      showMdPicker: false,
      sendStatus: ""
    };
    this.initialState = { ...this.state };
    this.handleChange = this.handleChange.bind(this);
    this.handleChangeCheckbox = this.handleChangeCheckbox.bind(this);
    this.getActualAddress = this.getActualAddress.bind(this);
    this.getMovingAddress = this.getMovingAddress.bind(this);
  }

  componentWillMount() {
    if (this.props.date) {
      const { date } = this.props;
      this.setState({
        movingDate: date,
        movingYear: date.substring(0, 4),
        movingMonth: date.substring(5, 7),
        movingDay: date.substring(8, 10)
      });
    }
    if (this.props.id) {
      axios
        .post(`${API_URL}fetchMoving.php`, {
          clientId: this.props.id
        })
        .then(response => {
          const res = response.data[0];
          const birthYear =
              res.birthday === null ? "" : res.birthday.substring(0, 4),
            birthMonth =
              res.birthday === null ? "" : res.birthday.substring(5, 7),
            birthDay =
              res.birthday === null ? "" : res.birthday.substring(8, 10),
            tL = /^[^-]*[^-]/,
            tR = /\w[^-]*$/,
            tel1L = res.tel_1 !== "" ? res.tel_1.match(tL)[0] : "",
            tel1C = res.tel_1 !== "" ? res.tel_1.match("-(.*)-")[1] : "",
            tel1R = res.tel_1 !== "" ? res.tel_1.match(tR)[0] : "",
            tel2C = res.tel_2 !== "" ? res.tel_2.match("-(.*)-")[1] : "",
            tel2R = res.tel_2 !== "" ? res.tel_2.match(tR)[0] : "",
            tel2L = res.tel_2 !== "" ? res.tel_2.match(tL)[0] : "",
            contactableYear1 =
              res.contactable_date_1 === null
                ? ""
                : res.contactable_date_1.substring(0, 4),
            contactableMonth1 =
              res.contactable_date_1 === null
                ? ""
                : res.contactable_date_1.substring(5, 7),
            contactableDay1 =
              res.contactable_date_1 === null
                ? ""
                : res.contactable_date_1.substring(8, 10),
            contactableTimeFrom1 =
              res.contactable_time_from_1 === null
                ? ""
                : res.contactable_time_from_1.substring(0, 2),
            contactableTimeTo1 =
              res.contactable_time_to_1 === null
                ? ""
                : res.contactable_time_to_1.substring(0, 2),
            contactableYear2 =
              res.contactable_date_2 === null
                ? ""
                : res.contactable_date_2.substring(0, 4),
            contactableMonth2 =
              res.contactable_date_2 === null
                ? ""
                : res.contactable_date_2.substring(5, 7),
            contactableDay2 =
              res.contactable_date_2 === null
                ? ""
                : res.contactable_date_2.substring(8, 10),
            contactableTimeFrom2 =
              res.contactable_time_from_2 === null
                ? ""
                : res.contactable_time_from_2.substring(0, 2),
            contactableTimeTo2 =
              res.contactable_time_to_2 === null
                ? ""
                : res.contactable_time_to_1.substring(0, 2),
            movingYear =
              res.moving_date === null ? "" : res.moving_date.substring(0, 4),
            movingMonth =
              res.moving_date === null ? "" : res.moving_date.substring(5, 7),
            movingDay =
              res.moving_date === null ? "" : res.moving_date.substring(8, 10),
            actualPostalCodePrefix =
              res.actual_postal_code === null
                ? ""
                : res.actual_postal_code.substring(0, 3),
            actualPostalCodeSufix =
              res.actual_postal_code === null
                ? ""
                : res.actual_postal_code.substring(4, 8);
          this.setState({
            id: parseInt(res.id),
            lastName: res.last_name,
            firstName: res.first_name,
            lastNameKana: res.last_name_kana,
            firstNameKana: res.first_name_kana,
            genre: res.genre,
            birthDate: res.birthday === null ? "" : res.birthday,
            birthYear,
            birthMonth,
            birthDay,
            email: res.email,
            tel1L,
            tel1C,
            tel1R,
            tel1: res.tel_1,
            tel2L,
            tel2C,
            tel2R,
            tel2: res.tel_2,
            carrier: res.carrier,
            contactable: res.contactable,
            contactableYear1,
            contactableMonth1,
            contactableDay1,
            contactableDate1:
              res.contactable_date_1 === null ? "" : res.contactable_date_1,
            contactableTimeFrom1: contactableTimeFrom1,
            contactableTimeTo1: contactableTimeTo1,
            contactableYear2,
            contactableMonth2,
            contactableDay2,
            contactableDate2:
              res.contactable_date_2 === null ? "" : res.contactable_date_2,
            contactableTimeFrom2: contactableTimeFrom2,
            contactableTimeTo2: contactableTimeTo2,
            actualPostalCodePrefix,
            actualPostalCodeSufix,
            actualPostalCode: res.actual_postal_code,
            actualAddress1: res.actual_address_1,
            actualAddress2: res.actual_address_2,
            actualAddress3: res.actual_address_3,
            actualAddress4: res.actual_address_4,
            actualInfra: res.actual_infra,
            movingDate: res.moving_date === null ? "" : res.moving_date,
            movingYear,
            movingMonth,
            movingDay,
            movingPostalCode: res.moving_postal_code,
            movingAddress1: res.moving_address_1,
            movingAddress2: res.moving_address_2,
            movingAddress3: res.moving_address_3,
            movingAddress4: res.moving_address_4,
            electrical: res.electrical,
            internet: res.internet,
            cityGas: res.city_gas,
            oaEquipment: res.oa_equipment,
            propaneGas: res.propane_gas,
            hpSecurity: res.hp_security,
            water: res.water,
            waterServer: res.water_server,
            electricalStatus: res.electrical_status,
            gasStatus: res.gas_status,
            internetStatus: res.internet_status,
            homeSecurityStatus: res.home_security_status,
            memo: res.memo
          });
        });
    } else {
      if (localStorage.getItem("movingState") !== null) {
        this.setState(JSON.parse(localStorage.getItem("movingState")));
      }
    }
  }

  handleChange(event) {
    const intNames = ["carrier", "contactable"];
    const name = event.target.getAttribute("name");
    const value = intNames.includes(name)
      ? parseInt(event.target.value, 10)
      : event.target.value;
    this.setState({ [name]: value });
  }

  handleBlurDate(event) {
    const {
      birthYear,
      birthMonth,
      birthDay,
      movingYear,
      movingMonth,
      movingDay
    } = this.state;
    this.setState({
      birthDate:
        birthYear && birthMonth && birthDay
          ? `${birthYear}-${birthMonth}-${birthDay}`
          : "",
      movingDate:
        movingYear && movingMonth && movingDay
          ? `${movingYear}-${movingMonth}-${movingDay}`
          : null
    });
  }

  handleBlurTel() {
    const { tel1L, tel1C, tel1R, tel2L, tel2C, tel2R } = this.state;
    this.setState({
      tel1L,
      tel1C,
      tel1R,
      tel2L,
      tel2C,
      tel2R,
      tel1: tel1L && tel1C && tel1R ? `${tel1L}-${tel1C}-${tel1R}` : null,
      tel2: tel2L && tel2C && tel2R ? `${tel2L}-${tel2C}-${tel2R}` : null
    });
  }

  handleBlurContactable() {
    const {
      contactableYear1,
      contactableMonth1,
      contactableDay1,
      contactableTimeFrom1,
      contactableTimeTo1,
      contactableableDate1,
      contactableYear2,
      contactableMonth2,
      contactableDay2,
      contactableTimeFrom2,
      contactableTimeTo2,
      contactableableDate2
    } = this.state;
    this.setState({
      contactableYear1,
      contactableMonth1,
      contactableDay1,
      contactableDate1:
        contactableYear1 && contactableMonth1 && contactableDay1
          ? `${contactableYear1}-${contactableMonth1}-${contactableDay1}`
          : "",
      contactableTimeFrom1: contactableTimeFrom1 ? contactableTimeFrom1 : "",
      contactableTimeTo1: contactableTimeTo1 ? contactableTimeTo1 : "",
      contactableYear2,
      contactableMonth2,
      contactableDay2,
      contactableDate2:
        contactableYear2 && contactableMonth2 && contactableDay2
          ? `${contactableYear2}-${contactableMonth2}-${contactableDay2}`
          : "",
      contactableTimeFrom2: contactableTimeFrom2 ? contactableTimeFrom2 : "",
      contactableTimeTo2: contactableTimeTo2 ? contactableTimeTo2 : ""
    });
  }

  handleBlurPostalCode() {
    const {
      actualPostalCodePrefix,
      actualPostalCodeSufix,
      movingPostalCodePrefix,
      movingPostalCodeSufix
    } = this.state;
    this.setState({
      actualPostalCode: `${actualPostalCodePrefix}-${actualPostalCodeSufix}`,
      movingPostalCode: `${movingPostalCodePrefix}-${movingPostalCodeSufix}`
    });
  }

  handleChangeCheckbox(event) {
    const name = event.target.getAttribute("name");
    const value = event.target.value === "true" ? false : true;
    this.setState({
      [name]: value
    });
  }

  onKeyPress(event) {
    if (event.which === 13 /* Enter */) {
      event.preventDefault();
    }
  }

  getActualAddress(event) {
    event.preventDefault();
    let postalCode;
    this.setState({
      actualAddress1: "",
      actualAddress2: "",
      actualAddress3: "",
      actualAddress4: ""
    });
    postalCode = parseInt(
      `${this.state.actualPostalCodePrefix}${this.state.actualPostalCodeSufix}`
    );
    axios.get(`${API_URL}postalCodeStr.json`).then(response => {
      const addresses = response.data;
      const address = addresses.filter(add => add.code === postalCode);
      if (typeof address[0] == "undefined") {
        alert("住所見つかりませんでした。");
      }
      this.setState({
        actualAddress1: address[0].a1,
        actualAddress2: address[0].a2,
        actualAddress3: address[0].a3
      });
    });
  }

  getMovingAddress(event) {
    event.preventDefault();
    let postalCode;
    this.setState({
      movingAddress1: "",
      movingAddress2: "",
      movingAddress3: "",
      movingAddress4: ""
    });
    postalCode = parseInt(
      `${this.state.movingPostalCodePrefix}${this.state.movingPostalCodeSufix}`
    );
    axios.get(`${API_URL}postalCodeStr.json`).then(response => {
      const addresses = response.data;
      const address = addresses.filter(add => add.code === postalCode);
      if (typeof address[0] == "undefined") {
        alert("住所見つかりませんでした。");
      }
      this.setState({
        movingAddress1: address[0].a1,
        movingAddress2: address[0].a2,
        movingAddress3: address[0].a3
      });
    });
  }

  onClickBdPicker() {
    this.setState({ showBdPicker: !this.state.showBdPicker });
  }

  onClickC1Picker() {
    this.setState({ showC1Picker: !this.state.showC1Picker });
  }

  onClickC2Picker() {
    this.setState({ showC2Picker: !this.state.showC2Picker });
  }

  onClickMdPicker() {
    this.setState({ showMdPicker: !this.state.showMdPicker });
  }

  onChangeBdPicker(jsDate) {
    this.setState({
      birthYear: moment(jsDate).format("YYYY"),
      birthMonth: moment(jsDate).format("MM"),
      birthDay: moment(jsDate).format("DD"),
      birthDate: `${moment(jsDate).format("YYYY")}-${moment(jsDate).format(
        "MM"
      )}-${moment(jsDate).format("DD")}`,
      showBdPicker: false
    });
  }

  onChangeC1Picker(jsDate) {
    this.setState({
      contactableYear1: moment(jsDate).format("YYYY"),
      contactableMonth1: moment(jsDate).format("MM"),
      contactableDay1: moment(jsDate).format("DD"),
      contactableDate1: `${moment(jsDate).format("YYYY")}-${moment(
        jsDate
      ).format("MM")}-${moment(jsDate).format("DD")}`,
      showC1Picker: false
    });
  }

  onChangeC2Picker(jsDate) {
    this.setState({
      contactableYear2: moment(jsDate).format("YYYY"),
      contactableMonth2: moment(jsDate).format("MM"),
      contactableDay2: moment(jsDate).format("DD"),
      contactableDate2: `${moment(jsDate).format("YYYY")}-${moment(
        jsDate
      ).format("MM")}-${moment(jsDate).format("DD")}`,
      showC2Picker: false
    });
  }

  onChangeMdPicker(jsDate) {
    this.setState({
      movingYear: moment(jsDate).format("YYYY"),
      movingMonth: moment(jsDate).format("MM"),
      movingDay: moment(jsDate).format("DD"),
      movingDate: `${moment(jsDate).format("YYYY")}-${moment(jsDate).format(
        "MM"
      )}-${moment(jsDate).format("DD")}`,
      showMdPicker: false
    });
  }

  handleSubmit(event) {
    axios
      .post(`${API_URL}updateMoving.php`, {
        id: this.state.id,
        lastName: this.state.lastName,
        firstName: this.state.firstName,
        lastNameKana: this.state.lastNameKana,
        firstNameKana: this.state.firstNameKana,
        genre: this.state.genre,
        birthDate: this.state.birthDate !== "" ? this.state.birthDate : "",
        email: this.state.email,
        tel1: this.state.tel1,
        tel2: this.state.tel2,
        carrier: this.state.carrier,
        contactable: this.state.contactable,
        contactableTimeFrom1: this.state.contactableTimeFrom1,
        contactableTimeTo1: this.state.contactableTimeTo1,
        contactableDate1:
          this.state.contactableDate1 !== "" ? this.state.contactableDate1 : "",
        contactableDate2:
          this.state.contactableDate2 !== "" ? this.state.contactableDate2 : "",
        contactableTimeFrom2: this.state.contactableTimeFrom2,
        contactableTimeTo2: this.state.contactableTimeTo2,
        actualPostalCode: this.state.actualPostalCode,
        actualAddress1: this.state.actualAddress1,
        actualAddress2: this.state.actualAddress2,
        actualAddress3: this.state.actualAddress3,
        actualAddress4: this.state.actualAddress4,
        actualInfra: this.state.actualInfra,
        movingDate: this.state.movingDate !== "" ? this.state.movingDate : "",
        movingPostalCode: this.state.movingPostalCode,
        movingAddress1: this.state.movingAddress1,
        movingAddress2: this.state.movingAddress2,
        movingAddress3: this.state.movingAddress3,
        movingAddress4: this.state.movingAddress4,
        electrical: this.state.electrical,
        internet: this.state.internet,
        cityGas: this.state.cityGas,
        oaEquipment: this.state.oaEquipment,
        propaneGas: this.state.propaneGas,
        hpSecurity: this.state.hpSecurity,
        water: this.state.water,
        waterServer: this.state.waterServer,
        electricalStatus: this.state.electricalStatus,
        gasStatus: this.state.gasStatus,
        internetStatus: this.state.internetStatus,
        homeSecurityStatus: this.state.homeSecurityStatus,
        memo: this.state.memo
      })
      .then(response => {
        if (response.data === "success") {
          this.setState(this.initialState);
          if (localStorage.getItem("movingState") !== null) {
            localStorage.removeItem("movingState");
          }
          this.setState({ sendStatus: "success" });
        } else if (response.data === "failed") {
          localStorage.setItem("movingState", JSON.stringify(this.state));
          this.setState({ sendStatus: "failed" });
        }
        const sendStatus = this.state.sendStatus;
        this.props.sendStatus({ sendStatus });
      })
      .catch(function(error) {
        console.log(error);
      });
  }

  render() {
    const date = moment();
    return (
      <div style={{ position: "relative" }}>
        <form className="form" onKeyPress={this.onKeyPress.bind(this)}>
          <h3>■基本情報</h3>
          {/* Name Field */}
          <div className="row">
            <label>顧客指名</label>
            <div className="fields">
              <input
                type="text"
                name="lastName"
                placeholder="性"
                value={this.state.lastName}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="firstName"
                placeholder="名"
                value={this.state.firstName}
                onChange={this.handleChange}
              />
            </div>
          </div>
          {/* Name Kana Field */}
          <div className="row">
            <label>顧客氏名カナ</label>
            <div className="fields">
              <input
                type="text"
                name="lastNameKana"
                placeholder="セイ"
                value={this.state.lastNameKana}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="firstNameKana"
                placeholder="メイ"
                value={this.state.firstNameKana}
                onChange={this.handleChange}
              />
            </div>
          </div>
          <div className="row">
            <label>性別</label>
            <div className="fields">
              <select
                className="dropdown"
                name="genre"
                value={this.state.genre}
                onChange={this.handleChange}
              >
                <option value="0">性別</option>
                <option value="1">女性</option>
                <option value="2">男性</option>
              </select>
            </div>
          </div>
          {/* Date Field */}
          <div className="row">
            <label>生年月日</label>
            <div
              className="fields"
              style={{ alignItems: "flex-start", position: "relative" }}
            >
              <input
                type="text"
                name="birthYear"
                className="inputDate"
                placeholder="1900"
                value={this.state.birthYear}
                onChange={this.handleChange}
                onBlur={this.handleBlurDate.bind(this)}
              />
              <span>年</span>
              <input
                type="text"
                name="birthMonth"
                className="inputDate"
                placeholder="01"
                value={this.state.birthMonth}
                onChange={this.handleChange}
                onBlur={this.handleBlurDate.bind(this)}
              />
              <span>月</span>
              <input
                type="text"
                name="birthDay"
                className="inputDate"
                placeholder="01"
                value={this.state.birthDay}
                onChange={this.handleChange}
                onBlur={this.handleBlurDate.bind(this)}
              />
              <span>日</span>
              <FontAwesomeIcon
                icon={faCalendarAlt}
                size="2x"
                style={{ marginLeft: "1rem", position: "relative" }}
                color="#3498DB"
                onClick={this.onClickBdPicker.bind(this)}
              />
              {this.state.showBdPicker && (
                <DatePicker
                  locale="ja"
                  onChange={this.onChangeBdPicker.bind(this)}
                  value={date}
                  style={{
                    position: "absolute",
                    top: "3rem",
                    left: "46.5%",
                    transform: "translateX(-50%)",
                    boxShadow: "10px 10px 8px -5px rgba(0,0,0,0.17)",
                    zIndex: 1
                  }}
                />
              )}
            </div>
          </div>
          {/* email Field */}
          <div className="row">
            <label>Email</label>
            <div className="fields">
              <input
                type="text"
                name="email"
                value={this.state.email}
                placeholder="tanaka@example.com"
                onChange={this.handleChange}
              />
            </div>
          </div>
          {/* contactable fields */}
          <div className="row contact">
            <label>連絡先①</label>
            <div className="fields">
              <div className="col">
                <input
                  type="text"
                  name="tel1L"
                  placeholder="999"
                  value={this.state.tel1L}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurTel.bind(this)}
                />
                <span>-</span>
                <input
                  type="text"
                  name="tel1C"
                  placeholder="9999"
                  value={this.state.tel1C}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurTel.bind(this)}
                />
                <span>-</span>
                <input
                  type="text"
                  name="tel1R"
                  placeholder="9999"
                  value={this.state.t1R}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurTel.bind(this)}
                />
              </div>
            </div>
          </div>

          <div className="row contact">
            <label>連絡先②</label>
            <div className="fields">
              <div className="col">
                <input
                  type="text"
                  name="tel2L"
                  placeholder="999"
                  value={this.state.tel2L}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurTel.bind(this)}
                />
                <span>-</span>
                <input
                  type="text"
                  name="tel2C"
                  placeholder="9999"
                  value={this.state.tel2C}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurTel.bind(this)}
                />
                <span>-</span>
                <input
                  type="text"
                  name="tel2R"
                  placeholder="9999"
                  value={this.state.tel2R}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurTel.bind(this)}
                />
              </div>
            </div>
          </div>

          {/* mobile carrier field */}
          <div className="row">
            <label>携帯電話会社</label>
            <div className="fields" onChange={this.handleChange}>
              <select name="carrier">
                <option value="0">選択</option>
                <option value="1">DoCoMo</option>
                <option value="2">au</option>
                <option value="3">SoftBank</option>
                <option value="4">その他</option>
              </select>
            </div>
          </div>

          {/* 確認連絡希望日時 */}
          <div className="row">
            <label>確認連絡希望日時</label>
            <div className="fields">
              <select
                name="contactable"
                value={this.state.contactable}
                onChange={this.handleChange}
              >
                <option value="0">選択</option>
                <option value="1">希望あり</option>
                <option value="2">いつでも良い</option>
                <option value="3">最短で良い</option>
              </select>
            </div>
          </div>

          {/* 希望① */}
          {this.state.contactable != 0 && (
            <Fragment>
              <div className="row contact">
                <label>希望①</label>
                <div className="fields" style={{ position: "relative" }}>
                  <div className="col">
                    <input
                      type="text"
                      name="contactableYear1"
                      placeholder="1900"
                      value={this.state.contactableYear1}
                      onChange={this.handleChange}
                      onBlur={this.handleBlurContactable.bind(this)}
                    />
                    <span>年</span>
                    <input
                      type="text"
                      name="contactableMonth1"
                      placeholder="99"
                      value={this.state.contactableMonth1}
                      onChange={this.handleChange}
                      onBlur={this.handleBlurContactable.bind(this)}
                    />
                    <span>月</span>
                    <input
                      type="text"
                      name="contactableDay1"
                      placeholder="99"
                      value={this.state.contactableDay1}
                      onChange={this.handleChange}
                      onBlur={this.handleBlurContactable.bind(this)}
                    />
                    <span>日</span>
                    <FontAwesomeIcon
                      icon={faCalendarAlt}
                      size="2x"
                      style={{ margin: "0 3rem 0 1rem", position: "relative" }}
                      color="#3498DB"
                      onClick={this.onClickC1Picker.bind(this)}
                    />
                    {this.state.showC1Picker && (
                      <DatePicker
                        locale="ja"
                        onChange={this.onChangeC1Picker.bind(this)}
                        value={date}
                        style={{
                          position: "absolute",
                          top: "3rem",
                          left: "46.5%",
                          transform: "translateX(-50%)",
                          boxShadow: "10px 10px 8px -5px rgba(0,0,0,0.17)",
                          zIndex: 1
                        }}
                      />
                    )}
                    <span className="datepicker" />
                    <input
                      type="text"
                      name="contactableTimeFrom1"
                      placeholder="00"
                      value={this.state.contactableTimeFrom1}
                      onChange={this.handleChange}
                      onBlur={this.handleBlurContactable.bind(this)}
                    />
                    <span>時　〜</span>
                    <input
                      type="text"
                      name="contactableTimeTo1"
                      placeholder="00"
                      value={this.state.contactableTimeTo1}
                      onChange={this.handleChange}
                      onBlur={this.handleBlurContactable.bind(this)}
                    />
                    <span>時</span>
                  </div>
                </div>
              </div>

              <div className="row contact">
                <label>希望②</label>
                <div className="fields" style={{ position: "relative" }}>
                  <div className="col" />
                  <input
                    type="text"
                    name="contactableYear2"
                    className=""
                    placeholder="1900"
                    value={this.state.contactableYear2}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurContactable.bind(this)}
                  />
                  <span>年</span>
                  <input
                    type="text"
                    name="contactableMonth2"
                    placeholder="99"
                    value={this.state.contactableMonth2}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurContactable.bind(this)}
                  />
                  <span>月</span>
                  <input
                    type="text"
                    name="contactableDay2"
                    placeholder="99"
                    value={this.state.contactableDay2}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurContactable.bind(this)}
                  />
                  <span>日</span>
                  <FontAwesomeIcon
                    icon={faCalendarAlt}
                    size="2x"
                    style={{ margin: "0 3rem 0 1rem", position: "relative" }}
                    color="#3498DB"
                    onClick={this.onClickC2Picker.bind(this)}
                  />
                  {this.state.showC2Picker && (
                    <DatePicker
                      locale="ja"
                      onChange={this.onChangeC2Picker.bind(this)}
                      value={date}
                      style={{
                        position: "absolute",
                        top: "3rem",
                        left: "46.5%",
                        transform: "translateX(-50%)",
                        boxShadow: "10px 10px 8px -5px rgba(0,0,0,0.17)",
                        zIndex: 1
                      }}
                    />
                  )}
                  <input
                    type="text"
                    name="contactableTimeFrom2"
                    placeholder="00"
                    value={this.state.contactableTimeFrom2}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurContactable.bind(this)}
                  />
                  <span>時　〜</span>
                  <input
                    type="text"
                    name="contactableTimeTo2"
                    placeholder="00"
                    value={this.state.contactableTimeTo2}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurContactable.bind(this)}
                  />
                  <span>時</span>
                </div>
              </div>
            </Fragment>
          )}

          <h3>■引越前情報</h3>
          <div className="row">
            <label>郵便番号</label>
            <div className="fields">
              <input
                type="text"
                name="actualPostalCodePrefix"
                placeholder="999"
                value={this.state.actualPostalCodePrefix}
                onChange={this.handleChange}
                onBlur={this.handleBlurPostalCode.bind(this)}
              />
              <span> - </span>
              <input
                type="text"
                name="actualPostalCodeSufix"
                placeholder="9999"
                value={this.state.actualPostalCodeSufix}
                onChange={this.handleChange}
                onBlur={this.handleBlurPostalCode.bind(this)}
              />
              <FontAwesomeIcon
                icon={faSearchLocation}
                size="2x"
                style={{ marginLeft: "1rem", position: "relative" }}
                color="#3498DB"
                onClick={this.getActualAddress}
              />
            </div>
          </div>
          <div className="row">
            <label htmlFor="">引越前住所</label>
            <div className="fields">
              <input
                type="text"
                name="actualAddress1"
                placeholder="都道府県"
                value={this.state.actualAddress1}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="actualAddress2"
                placeholder="市区町村"
                value={this.state.actualAddress2}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="actualAddress3"
                placeholder="番地"
                value={this.state.actualAddress3}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="actualAddress4"
                placeholder="マンション名、号"
                value={this.state.actualAddress4}
                onChange={this.handleChange}
              />
            </div>
          </div>
          <div className="row">
            <label htmlFor="">引越前インフラ</label>
            <div className="fields">
              <select name="actualInfra" onChange={this.handleChange}>
                <option value="0">そのまま</option>
                <option value="1">閉鎖</option>
              </select>
            </div>
          </div>
          <h3>■引越後情報</h3>
          {/*  Expected Moving Date Field */}
          <div className="row">
            <label htmlFor="">入居予定日</label>
            <div className="fields" style={{ position: "relative" }}>
              <input
                type="text"
                name="movingYear"
                placeholder="1900"
                value={this.state.movingYear}
                onChange={this.handleChange}
                onBlur={this.handleBlurDate.bind(this)}
                className="inputDate"
              />
              <span>年</span>
              <input
                type="text"
                name="movingMonth"
                placeholder="00"
                value={this.state.movingMonth}
                onChange={this.handleChange}
                onBlur={this.handleBlurDate.bind(this)}
                className="inputDate"
              />
              <span>月</span>
              <input
                type="text"
                name="movingDay"
                placeholder="00"
                value={this.state.movingDay}
                onChange={this.handleChange}
                onBlur={this.handleBlurDate.bind(this)}
                className="inputDate"
              />
              <span>日</span>
              <FontAwesomeIcon
                icon={faCalendarAlt}
                size="2x"
                style={{ margin: "0 3rem 0 1rem", position: "relative" }}
                color="#3498DB"
                onClick={this.onClickMdPicker.bind(this)}
              />
              {this.state.showMdPicker && (
                <DatePicker
                  locale="ja"
                  onChange={this.onChangeMdPicker.bind(this)}
                  value={date}
                  style={{
                    position: "absolute",
                    top: "3rem",
                    left: "46.5%",
                    transform: "translateX(-50%)",
                    boxShadow: "10px 10px 8px -5px rgba(0,0,0,0.17)",
                    zIndex: 1
                  }}
                />
              )}
            </div>
          </div>
          {/* Moving Address */}
          <div className="row">
            <label>郵便番号</label>
            <div className="fields">
              <input
                type="text"
                name="movingPostalCodePrefix"
                placeholder="999"
                value={this.state.movingPostalCodePrefix}
                onChange={this.handleChange}
                onBlur={this.handleBlurPostalCode.bind(this)}
                className="inputDate"
              />
              <span> - </span>
              <input
                type="text"
                name="movingPostalCodeSufix"
                placeholder="9999"
                value={this.state.movingPostalCodeSufix}
                onChange={this.handleChange}
                onBlur={this.handleBlurPostalCode.bind(this)}
                className="inputDate"
              />
              <FontAwesomeIcon
                icon={faSearchLocation}
                size="2x"
                style={{ marginLeft: "1rem", position: "relative" }}
                color="#3498DB"
                onClick={this.getMovingAddress}
              />
            </div>
          </div>
          <div className="row">
            <label htmlFor="">引越後住所</label>
            <div className="fields">
              <input
                type="text"
                name="movingAddress1"
                placeholder="都道府県"
                value={this.state.movingAddress1}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="movingAddress2"
                placeholder="市区町村"
                value={this.state.movingAddress2}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="movingAddress3"
                placeholder="番地"
                value={this.state.movingAddress3}
                onChange={this.handleChange}
              />
              <input
                type="text"
                name="movingAddress4"
                placeholder="マンション名、号"
                value={this.state.movingAddress4}
                onChange={this.handleChange}
              />
            </div>
          </div>

          <div className="row">
            <label htmlFor="">お客様ご要望</label>
            <div className="fields checkbox">
              <fieldset>
                <input
                  type="checkbox"
                  name="electrical"
                  value={this.state.electrical}
                  checked={!!this.state.electrical}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="electrical">電気</label>
              </fieldset>
              <fieldset>
                <input
                  type="checkbox"
                  name="internet"
                  value={this.state.internet}
                  checked={!!this.state.internet}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="internet">インターネット</label>
              </fieldset>
              <fieldset>
                <input
                  type="checkbox"
                  name="cityGas"
                  value={this.state.cityGas}
                  checked={!!this.state.cityGas}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="cityGas">都市ガス</label>
              </fieldset>

              <fieldset>
                <input
                  type="checkbox"
                  name="oaEquipment"
                  value={this.state.oaEquipment}
                  checked={!!this.state.oaEquipment}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="oaEquipment">OA機器等</label>
              </fieldset>

              <fieldset>
                <input
                  type="checkbox"
                  name="propaneGas"
                  value={this.state.propaneGas}
                  checked={!!this.state.propaneGas}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="propaneGas">プロパンガス</label>
              </fieldset>

              <fieldset>
                <input
                  type="checkbox"
                  name="hpSecurity"
                  value={this.state.hpSecurity}
                  checked={!!this.state.hpSecurity}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="hpSecurity">HP・セキュリティー</label>
              </fieldset>

              <fieldset>
                <input
                  type="checkbox"
                  name="water"
                  id="water"
                  value={this.state.water}
                  checked={!!this.state.water}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="water">水道</label>
              </fieldset>

              <fieldset>
                <input
                  type="checkbox"
                  name="waterServer"
                  value={this.state.waterServer}
                  checked={!!this.state.waterServer}
                  onChange={this.handleChangeCheckbox}
                />
                <label htmlFor="waterServer">ウォーターサーバー</label>
              </fieldset>
            </div>
          </div>

          <div className="row">
            <label htmlFor="">電気</label>
            <div className="fields">
              <select
                className="dropdown"
                name="electricalStatus"
                value={this.state.electricalStatus}
                onChange={this.handleChange}
              >
                電気
                <option value="0">未出力</option>
                <option value="1">出力済</option>
              </select>
            </div>
          </div>

          <div className="row">
            <label htmlFor="">ガス</label>
            <div className="fields">
              <select
                className="dropdown"
                name="gasStatus"
                value={this.state.gasStatus}
                onChange={this.handleChange}
              >
                <option value="">ガス出力ステータス</option>
                <option value="0">未出力</option>
                <option value="1">出力済</option>
              </select>
            </div>
          </div>

          <div className="row">
            <label htmlFor="">インターネット</label>
            <div className="fields">
              <select
                className="dropdown"
                name="internetStatus"
                value={this.state.internetStatus}
                onChange={this.handleChange}
              >
                <option value="">ステータス</option>
                <option value="0">？？</option>
                <option value="1">？？</option>
              </select>
            </div>
          </div>

          <div className="row">
            <label htmlFor="">ホームセキュリティ</label>
            <div className="fields">
              <select
                className="dropdown"
                name="homeSecurityStatus"
                value={this.state.homeSecurityStatus}
                onChange={this.handleChange}
              >
                <option value="">ステータス</option>
                <option value="0">？？</option>
                <option value="1">？？</option>
              </select>
            </div>
          </div>

          <div className="row">
            <label htmlFor="">メモ</label>
            <div className="fields">
              <textarea
                name="memo"
                rows="10"
                value={this.state.memo}
                onChange={this.handleChange}
              />
            </div>
          </div>

          <input
            type="button"
            value="更新"
            onClick={this.handleSubmit.bind(this)}
          />
        </form>
      </div>
    );
  }
}
