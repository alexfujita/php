import React, { Component, Fragment } from "react";
import { render } from "react-dom";
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";
import "../../sass/main.scss";
import { API_URL } from "../constants";

class FormView extends Component {
  constructor(props) {
    super(props);
    this.state = {
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
      carrier: 0,
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
      memo: ""
    };
  }

  componentWillMount() {
    axios
      .post(`${API_URL}fetchMoving.php`, {
        clientId: this.props.id
      })
      .then(response => {
        const res = response.data[0];
        this.setState({
          lastName: res.last_name,
          firstName: res.first_name,
          lastNameKana: res.last_name_kana,
          firstNameKana: res.first_name_kana,
          genre: parseInt(res.genre),
          birthDate: res.birthday,
          email: res.email,
          tel1: res.tel_1,
          tel2: res.tel_2,
          carrier: parseInt(res.carrier),
          contactable: res.contactable,
          contactableTimeFrom1: res.contactable_time_from_1,
          contactableTimeTo1: res.contactable_time_to_1,
          contactableDate1: res.contactable_date_1,
          contactableDate2: res.contactable_date_2,
          contactableTimeFrom2: res.contactable_time_from_2,
          contactableTimeTo2: res.contactable_time_to_2,
          actualPostalCode: res.actual_postal_code,
          actualAddress1: res.actual_address_1,
          actualAddress2: res.actual_address_2,
          actualAddress3: res.actual_address_3,
          actualInfra: res.actual_infra,
          movingDate: res.moving_date,
          movingPostalCode: res.moving_postal_code,
          movingAddress1: res.moving_address_1,
          movingAddress2: res.moving_address_2,
          movingAddress3: res.moving_address_3,
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
      })
      .catch(function(error) {
        console.log(error);
      });
  }

  onDismiss() {
    this.setState({ showModal: false });
  }

  render() {
    const {
      carrier,
      contactable,
      contactableDate1,
      contactableDate2
    } = this.state;
    return (
      <Fragment>
        <h3>■ 基本情報</h3>
        {/* Name Field */}
        <div className="row">
          <label>顧客指名</label>
          <div className="fields">
            <div>{this.state.lastName}</div>
            <div>　{this.state.firstName}</div>
          </div>
        </div>

        {/* Name Kana Field */}
        <div className="row">
          <label>顧客氏名カナ</label>
          <div className="fields">
            <div>{this.state.lastNameKana}</div>
            <div>　{this.state.firstNameKana}</div>
          </div>
        </div>

        <div className="row">
          <label>性別</label>
          <div className="fields">
            <div>
              {this.state.genre === 0
                ? "未選択"
                : this.state.genre === 1
                ? "女性"
                : "男性"}
            </div>
          </div>
        </div>
        {/* Date Field */}
        <div className="row">
          <label>生年月日</label>
          <div className="fields">
            <div>{this.state.birthDate ? this.state.birthDate : "未記入"}</div>
          </div>
        </div>
        {/* email Field */}
        <div className="row">
          <label>Email</label>
          <div className="fields">
            <div>{this.state.email}</div>
          </div>
        </div>
        {/* contactable fields */}
        <div className="row contact">
          <label>連絡先①</label>
          <div className="fields">
            <div className="col">
              <div>{this.state.tel1}</div>
            </div>
          </div>
        </div>

        <div className="row contact">
          <label>連絡先②</label>
          <div className="fields">
            <div className="col">
              <div>{this.state.tel2}</div>
            </div>
          </div>
        </div>

        {/* mobile carrier field */}
        <div className="row">
          <label>携帯電話会社</label>
          <div className="fields">
            {carrier === 1
              ? "DoCoMo"
              : carrier === 2
              ? "au"
              : carrier === 3
              ? "SoftBank"
              : carrier === 4
              ? "その他"
              : "未選択"}
          </div>
        </div>

        {/* 確認連絡希望日時 */}
        <div className="row">
          <label>確認連絡希望日時</label>
          <div className="fields">
            {contactable === 1
              ? "希望あり"
              : contactable === 2
              ? "いつでも良い"
              : contactable === 3
              ? "最短で良い"
              : "未選択"}
          </div>
        </div>

        {/* 希望① */}
        {this.state.contactable !== 0 && (
          <Fragment>
            <div className="row contact">
              <label>希望①</label>
              <div className="fields">
                <div className="col">
                  <div>
                    {contactableDate1
                      ? `${contactableDate1} ${
                          this.state.contactableTimeFrom1
                            ? this.state.contactableTimeFrom1.substring(0, 2) +
                              "時"
                            : ""
                        } 〜 ${
                          this.state.contactableTimeTo1
                            ? this.state.contactableTimeTo1.substring(0, 2) +
                              "時"
                            : ""
                        }`
                      : "未記入"}
                  </div>
                </div>
              </div>
            </div>

            <div className="row contact">
              <label>希望②</label>
              <div className="fields">
                <div className="col">
                  <div>
                    {contactableDate2
                      ? `${contactableDate2} ${
                          this.state.contactableTimeFrom2
                            ? this.state.contactableTimeFrom2.substring(0, 2) +
                              "時"
                            : ""
                        }〜${
                          this.state.contactableTimeTo2
                            ? this.state.contactableTimeTo2.substring(0, 2) +
                              "時"
                            : ""
                        }`
                      : "未記入"}
                  </div>
                </div>
              </div>
            </div>
          </Fragment>
        )}

        <h3>■引越前情報</h3>

        <div className="row">
          <label htmlFor="">引越前住所</label>
          <div className="fields">
            <div>
              {this.state.actualPostalCode} {this.state.actualAddress1}{" "}
              {this.state.actualAddress2} {this.state.actualAddress3}{" "}
              {this.state.actualAddress4}
            </div>
          </div>
        </div>

        <div className="row">
          <label>引越前インフラ</label>
          <div className="fields">
            <div>{this.state.actualInfra == 0 ? "そのまま" : "閉鎖"}</div>
          </div>
        </div>

        <h3>■引越後情報</h3>
        {/*  Expected Moving Date Field */}
        <div className="row">
          <label htmlFor="">入居予定日</label>
          <div className="fields">
            <div>{this.state.movingDate}</div>
          </div>
        </div>

        {/* Moving Address */}
        <div className="row">
          <label>引越後住所</label>
          <div className="fields">
            <div>
              {this.state.movingPostalCode} {this.state.movingAddress1}{" "}
              {this.state.movingAddress2} {this.state.movingAddress3}{" "}
              {this.state.movingAddress4}
            </div>
          </div>
        </div>

        <div className="row">
          <label htmlFor="">お客様ご要望</label>
          <div className="fields checkbox">
            {this.state.electrical ? "電気" : null}
            {this.state.internet ? "インターネット" : null}
            {this.state.cityGas ? "都市ガス" : null}
            {this.state.oaEquipment ? "OA機器等" : null}
            {this.state.propaneGas ? "プロパンガス" : null}
            {this.state.hpSecurity ? "HP・セキュリティー" : null}
            {this.state.water ? "水道" : null}
            {this.state.waterServer ? "ウォーターサーバー" : null}
          </div>
        </div>

        <div className="row">
          <label>電気</label>
          <div className="fields">
            <div>{this.state.electricalStatus == 0 ? "未出力" : "出力済"}</div>
          </div>
        </div>

        <div className="row">
          <label htmlFor="">ガス</label>
          <div className="fields">
            <div>{this.state.gasStatus == 0 ? "未出力" : "出力済"}</div>
          </div>
        </div>

        <div className="row">
          <label htmlFor="">インターネット</label>
          <div className="fields">
            {this.state.internetStatus ? "未出力" : "出力済"}
          </div>
        </div>

        <div className="row">
          <label htmlFor="">ホームセキュリティ</label>
          <div className="fields">
            {this.state.homeSecurityStatus ? "未出力" : "出力済"}
          </div>
        </div>

        <div className="row">
          <label htmlFor="">メモ</label>
          <div className="fields">
            <div>{this.state.memo}</div>
          </div>
        </div>
      </Fragment>
    );
  }
}

export default FormView;
