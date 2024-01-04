import React, { Fragment } from "react";
import FooterCopyright from "./components/footerCopyright";
import axios from "axios";
import { DatePicker, DatePickerInput } from "rc-datepicker";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faSearchLocation } from "@fortawesome/free-solid-svg-icons";
import { API_URL } from "./constants";

export default class Master extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      ownerName: "",
      ownerBankCode: "",
      ownerBranchCode: "",
      ownerAccountType: "",
      ownerAccountNr: "",
      ownerAccountName: "",
      agencyName: "",
      agencyPostalCodePrefix: "",
      agencyPostalCodeSufix: "",
      agencyPostalCode: "",
      agencyAddress1: "",
      agencyAddress2: "",
      agencyAddress3: "",
      agencyAddress4: "",
      agencyTelL: "",
      agencyTelC: "",
      agencyTelR: "",
      agencyFaxL: "",
      agencyFaxC: "",
      agencyFaxR: "",
      agencyBankName: "",
      agencyBankCode: "",
      agencyBranchName: "",
      agencyBranchCode: "",
      agencyBranchName: "",
      agencyAccountType: "",
      agencyAccountNr: "",
      agencyAccountName: "",
      commission: "",
      userCode: "",
      useStatus: "",
      formMaster: "",
      agencies: []
    };
    this.initialState = { ...this.state };
    this.handleChange = this.handleChange.bind(this);
    this.getAddress = this.getAddress.bind(this);
  }

  componentWillMount() {
    this.setState({ userCode: "01001" });
  }

  componentDidMount() {
    if (this.props.master === "formCreate") {
      this.setState({ formMaster: "create" });
    }
    if (this.state.userCode !== "") {
      const userGroup = this.state.userCode.substring(0, 2);
      axios
        .get(`${API_URL}fetchAgencies?userGroup=${userGroup}`)
        .then(response => {
          this.setState({ agencies: response.data });
        })
        .catch(error => {
          console.log(error);
        });
    }
  }

  handleDismissModal() {}

  handleChange(event) {
    const name = event.target.getAttribute("name");
    const value = event.target.value;
    this.setState({ [name]: value });
  }

  handleChangeAgency(event) {
    const userCode = event.target.value;
    const agency = this.state.agencies.find(ag => ag.user_cd === userCode);
    console.log(agency);
    const {
      agency_name,
      bank_cd,
      bank_name,
      store_cd,
      store_name,
      deposits_event,
      account_no,
      account_name
    } = agency;
    this.setState({
      userCode: event.target.value,
      agencyName: agency_name,
      agencyBankCode: bank_cd,
      agencyBankName: bank_name,
      agencyBranchCode: store_cd,
      agencyBranchName: store_name,
      agencyAccountType: deposits_event,
      agencyAccountNr: account_no,
      agencyAccountName: account_name
    });
  }

  handleChangeProduct(event) {
    console.log(event.target.value);
  }

  handleBlurPostalCode() {
    const { agencyPostalCodePrefix, agencyPostalCodeSufix } = this.state;
    this.setState({
      agencyPostalCode: `${agencyPostalCodePrefix}-${agencyPostalCodeSufix}`
    });
  }

  getAddress(event) {
    event.preventDefault();
    let postalCode;
    this.setState({
      agencyAddress1: "",
      agencyAddress2: "",
      agencyAddress3: "",
      agencyAddress4: ""
    });
    postalCode = parseInt(
      `${this.state.agencyPostalCodePrefix}${this.state.agencyPostalCodeSufix}`
    );
    axios.get(`${API_URL}postalCodeStr.json`).then(response => {
      const addresses = response.data;
      const address = addresses.filter(add => add.code === postalCode);
      if (typeof address[0] == "undefined") {
        alert("住所見つかりませんでした。");
      }
      this.setState({
        agencyAddress1: address[0].a1,
        agencyAddress2: address[0].a2,
        agencyAddress3: address[0].a3
      });
    });
  }

  handleBlurTel() {
    const {
      agencyTelL,
      agencyTelC,
      agencyTelR,
      agencyFaxL,
      agencyFaxC,
      agencyFaxR
    } = this.state;
    this.setState({
      agencyTelL,
      agencyTelC,
      agencyTelR,
      agencyFaxL,
      agencyFaxC,
      agencyFaxR,
      agencyTel:
        agencyTelL && agencyTelC && agencyTelR
          ? `${agencyTelL}-${agencyTelC}-${agencyTelR}`
          : null,
      agencyFax:
        agencyFaxL && agencyFaxC && agencyFaxR
          ? `${agencyFaxL}-${agencyFaxC}-${agencyFaxR}`
          : null
    });
  }

  // 代理店新規登録
  handleClickCreate() {
    this.setState({
      formMaster: "edit",
      agencyName: "",
      agencyBankCode: "",
      agencyBranchCode: "",
      agencyAccountType: "",
      agencyAccountNr: "",
      agencyAccountName: "",
      commission: ""
    });
  }

  handleClickUpdate() {
    const {
      userCode,
      useStatus,
      ownerStatus,
      agencyName,
      agencyPostalCode,
      agencyBankName,
      agencyBankCode,
      agencyAddress1,
      agencyAddress2,
      agencyAddress3,
      agencyAddress4,
      agencyTelL,
      agencyTelC,
      agencyTelR,
      agencyFaxL,
      agencyFaxC,
      agencyFaxR,
      agencyBranchName,
      agencyBranchCode,
      agencyAccountType,
      agencyAccountNr,
      agencyAccountName
    } = this.state;
    const agencyTel = `${agencyTelL}-${agencyTelC}-${agencyTelR}`;
    const agencyFax = `${agencyFaxL}-${agencyFaxC}-${agencyFaxR}`;
    axios
      .post(`${API_URL}postAgency.php`, {
        userCode,
        useStatus,
        ownerStatus,
        agencyName,
        agencyPostalCode,
        agencyAddress1,
        agencyAddress2,
        agencyAddress3,
        agencyAddress4,
        agencyTel,
        agencyFax,
        agencyBankName,
        agencyBankCode,
        agencyBranchName,
        agencyBranchCode,
        agencyAccountType,
        agencyAccountNr,
        agencyAccountName
      })
      .then(response => {
        if (response.data === "success") {
          this.setState(this.initialState);
          if (localStorage.getItem("agencyState") !== null) {
            localStorage.removeItem("agencyState");
          }
        } else if (response.data === "failed") {
          localStorage.setItem("agencyState", JSON.stringify(this.state));
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  }

  render() {
    console.log(this.state.agencyName);
    return (
      <Fragment>
        {this.state.formMaster === "create" && (
          <div>
            <h3>■オーナー店舗</h3>
            <div className="row">
              <div className="col">
                <label htmlFor="">名称</label>
                <div className="field">
                  <input
                    type="text"
                    name="ownerName"
                    placeholder=""
                    value={this.state.ownerName}
                    onChange={this.handleChange}
                  />
                </div>
              </div>
            </div>

            <div className="row">
              <div className="col col20">
                <label>銀行コード</label>
                <input
                  type="text"
                  name="ownerBankCode"
                  placeholder=""
                  value={this.state.ownerBankCode}
                  onChange={this.handleChange}
                />
              </div>

              <div className="col col20">
                <label>支店コード</label>
                <input
                  type="text"
                  name="ownerBranchCode"
                  placeholder=""
                  value={this.state.ownerBranchCode}
                  onChange={this.handleChange}
                />
              </div>
              <div className="col col10">
                <label>種目</label>
                <select
                  name="ownerAccountType"
                  value={this.state.ownerAccountType}
                  onChange={this.handleChange}
                >
                  <option value="">選択</option>
                  <option value="0">普通預金</option>
                  <option value="1">当座預金</option>
                </select>
              </div>
              <div className="col col25">
                <label htmlFor="">口座番号</label>
                <input
                  type="text"
                  name="ownerAccountNr"
                  placeholder=""
                  value={this.state.ownerAccountNr}
                  onChange={this.handleChange}
                />
              </div>
              <div className="col col25">
                <label>口座名義</label>
                <input
                  type="text"
                  name="ownerAccountName"
                  value={this.state.ownerAccountName}
                  onChange={this.handleChange}
                />
              </div>
            </div>
          </div>
        )}

        <div className="row">
          <h3>■代理店情報</h3>
          {this.state.formMaster === "create" && (
            <div>
              <button />
              <button>直近</button>
              <button />
            </div>
          )}
        </div>

        {this.state.formMaster === "edit" && (
          <div className="row">
            <div className="col">
              <label htmlFor="">オーナーステータス</label>
              <div className="col75">
                <select
                  name="ownerStatus"
                  value={this.state.ownerStatus}
                  onChange={this.handleChange}
                >
                  <option value="">選択</option>
                  <option value="1">オーナー店</option>
                  <option value="2">代理店</option>
                </select>
              </div>
            </div>

            <div className="col">
              <label htmlFor="">利用ステータス</label>
              <div className="col75">
                <select
                  name="useStatus"
                  value={this.state.useStatus}
                  onChange={this.handleChange}
                >
                  <option value="">選択</option>
                  <option value="0">全部利用可</option>
                  <option value="1">一部利用可</option>
                </select>
              </div>
            </div>
            <div className="col">
              <label htmlFor="">ユーザーコード</label>
              <div className="col75">
                <input
                  type="text"
                  name="userCode"
                  value={this.state.userCode}
                  onChange={this.handleChange}
                />
              </div>
            </div>
          </div>
        )}

        {/* 代理店名 */}
        <div className="row">
          <div className="col">
            <label htmlFor="">名称</label>
            <div className="col75">
              {this.state.formMaster === "create" ? (
                <select
                  name="agencyName"
                  value={this.state.userCode}
                  onChange={this.handleChangeAgency.bind(this)}
                >
                  <option value="">選択</option>
                  {this.state.agencies &&
                    this.state.agencies.map(agency => {
                      return (
                        <option key={agency.id} value={agency.user_cd}>
                          {agency.agency_name}
                        </option>
                      );
                    })}
                </select>
              ) : (
                <input
                  type="text"
                  name="agencyName"
                  value={this.state.agencyName}
                  onChange={this.handleChange}
                />
              )}
            </div>
          </div>
        </div>

        {/* 代理店住所 */}
        {this.state.formMaster === "edit" && (
          <Fragment>
            <div className="row">
              <label htmlFor="">郵便番号</label>
              <div className="fields">
                <input
                  type="text"
                  name="agencyPostalCodePrefix"
                  placeholder="999"
                  value={this.state.agencyPostalCodePrefix}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurPostalCode.bind(this)}
                />
                <span> - </span>
                <input
                  type="text"
                  name="agencyPostalCodeSufix"
                  placeholder="9999"
                  value={this.state.agencyPostalCodeSufix}
                  onChange={this.handleChange}
                  onBlur={this.handleBlurPostalCode.bind(this)}
                />
                <FontAwesomeIcon
                  icon={faSearchLocation}
                  size="2x"
                  style={{ marginLeft: "1rem", position: "relative" }}
                  color="#3498DB"
                  onClick={this.getAddress}
                />
              </div>
            </div>

            <div className="row">
              <div className="fields address">
                <input
                  type="text"
                  name="agencyAddress1"
                  placeholder="都道府県"
                  value={this.state.agencyAddress1}
                  onChange={this.handleChange}
                />
                <input
                  type="text"
                  name="agencyAddress2"
                  placeholder="市区"
                  value={this.state.agencyAddress2}
                  onChange={this.handleChange}
                />
                <input
                  type="text"
                  name="agencyAddress3"
                  placeholder="町村　番地"
                  value={this.state.agencyAddress3}
                  onChange={this.handleChange}
                />
                <input
                  type="text"
                  name="agencyAddress4"
                  placeholder="マンション名部屋番号"
                  value={this.state.agencyAddress4}
                  onChange={this.handleChange}
                />
              </div>
            </div>

            {/* 代理店電話番号 */}
            <div className="row contact">
              <label>電話番号</label>
              <div className="fields">
                <div className="col">
                  <input
                    type="text"
                    name="agencyTelL"
                    placeholder="999"
                    value={this.state.agencyTelL}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurTel.bind(this)}
                  />
                  <span>-</span>
                  <input
                    type="text"
                    name="agencyTelC"
                    placeholder="9999"
                    value={this.state.agencyTelC}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurTel.bind(this)}
                  />
                  <span>-</span>
                  <input
                    type="text"
                    name="agencyTelR"
                    placeholder="9999"
                    value={this.state.agencyTelR}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurTel.bind(this)}
                  />
                </div>
              </div>
            </div>

            {/* 代理店Fax番号 */}
            <div className="row contact">
              <label>Fax番号</label>
              <div className="fields">
                <div className="col">
                  <input
                    type="text"
                    name="agencyFaxL"
                    placeholder="999"
                    value={this.state.agencyFaxL}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurTel.bind(this)}
                  />
                  <span>-</span>
                  <input
                    type="text"
                    name="agencyFaxC"
                    placeholder="9999"
                    value={this.state.agencyFaxC}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurTel.bind(this)}
                  />
                  <span>-</span>
                  <input
                    type="text"
                    name="agencyFaxR"
                    placeholder="9999"
                    value={this.state.agencyFax1R}
                    onChange={this.handleChange}
                    onBlur={this.handleBlurTel.bind(this)}
                  />
                </div>
              </div>
            </div>
          </Fragment>
        )}

        {/* 銀行情報 */}
        <div className="row">
          <div className="col col25">
            <label htmlFor="">銀行コード</label>
            <input
              type="text"
              name="agencyBankCode"
              placeholder=""
              value={this.state.agencyBankCode}
              onChange={this.handleChange}
            />
          </div>

          <div className="col col25">
            <label htmlFor="">銀行名</label>
            <input
              type="text"
              name="agencyBankName"
              placeholder=""
              value={this.state.agencyBankName}
              onChange={this.handleChange}
            />
          </div>

          <div className="col col25">
            <label>支店コード</label>
            <input
              type="text"
              name="agencyBranchCode"
              placeholder=""
              value={this.state.agencyBranchCode}
              onChange={this.handleChange}
            />
          </div>

          <div className="col col25">
            <label>支店名</label>
            <input
              type="text"
              name="agencyBranchName"
              placeholder=""
              value={this.state.agencyBranchName}
              onChange={this.handleChange}
            />
          </div>
        </div>

        <div className="row">
          <div className="col col10">
            <label>種目</label>
            <select
              name="agencyAccountType"
              value={this.state.agencyAccountType}
              onChange={this.handleChange}
            >
              <option value="">選択</option>
              <option value="0">普通預金</option>
              <option value="1">当座預金</option>
            </select>
          </div>
          <div className="col col25">
            <label htmlFor="">口座番号</label>
            <input
              type="text"
              name="agencyAccountNr"
              placeholder=""
              value={this.state.agencyAccountNr}
              onChange={this.handleChange}
            />
          </div>
          <div className="col col25">
            <label htmlFor="">口座名義</label>
            <input
              type="text"
              name="agencyAccountName"
              placeholder=""
              value={this.state.agencyAccountName}
              onChange={this.handleChange}
            />
          </div>
        </div>

        <div className="row">
          <div className="col col50">
            <label htmlFor="">商品</label>
            <div className="col75">
              <select
                name="product"
                value={this.state.product}
                onChange={this.handleChangeProduct.bind(this)}
              >
                <option value="">選択</option>
              </select>
            </div>
          </div>

          <div className="col col50">
            <label htmlFor="">手数料</label>
            <div className="col75">
              <input
                type="text"
                name="commission"
                value={this.state.commission}
                onChange={this.handleChange}
              />
              <span>円</span>
            </div>
          </div>
        </div>

        <div
          className="modal__content--footer"
          style={{ margin: "2rem -2rem -2rem -2rem" }}
        >
          <div className="modal__content--footer-buttons">
            <button
              className="btn"
              onClick={this.handleDismissModal.bind(this)}
            >
              閉じる
            </button>
            {this.state.formMaster === "create" && (
              <button
                className="btn btn__primary"
                onClick={this.handleClickCreate.bind(this)}
              >
                新規
              </button>
            )}

            {this.state.formMaster === "create" && (
              <button className="btn btn__primary" onClick={this.handleSubmit}>
                確定
              </button>
            )}
            {this.state.formMaster === "edit" && (
              <button
                className="btn btn__primary"
                onClick={this.handleClickUpdate.bind(this)}
              >
                登録
              </button>
            )}
          </div>
          <FooterCopyright />
        </div>
      </Fragment>
    );
  }
}
