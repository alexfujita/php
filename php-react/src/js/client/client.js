import React, { Component, Fragment } from "react";
import axios from "axios";
import "../../sass/main.scss";
import { API_URL } from "../constants";

export default class Client extends Component {
  constructor(props) {
    super(props);
    this.state = {
      tel: "",
      cel: "",
      name: "",
      nameKana: "",
      genre: "",
      birthday: "",
      birthDate: "",
      postalCode: "",
      address: "",
      email: "",
      type: "",
      ratio: "",
      agree: ""
    };
  }

  componentDidMount() {
    // console.log("props", this.props);
    axios
      .post(`${API_URL}fetchClient.php`, {
        id: this.props.id
      })
      .then(response => {
        // console.log("response", response.data[0]);
        const res = response.data[0];
        let {
          tel,
          cel,
          last_name,
          first_name,
          last_name_kana,
          first_name_kana,
          genre,
          birthday,
          postal_code,
          address1,
          address2,
          address3,
          address4,
          email,
          insurance_type,
          burden_ratio,
          personal_info_agreement
        } = res;
        const name = `${last_name}　${first_name}`;
        const nameKana = `${last_name_kana}　${first_name_kana}`;
        genre = genre == 0 ? "女性" : "男性";
        const address = `〒${postal_code} ${address1}　${address2}　${address3}　${address4}`;
        let type, ratio;
        switch (insurance_type) {
          case "":
            type = "未選択";
            break;
          case "1":
            type = "協会けんぽ";
            break;
          case "2":
            type = "船舶保険";
            break;
          case "3":
            type = "日雇健康保険";
            break;
          case "4":
            type = "組合けんぽ";
            break;
          case "5":
            type = "自衛官診療証";
            break;
          case "6":
            type = "共済組合";
            break;
          case "7":
            type = "国保";
            break;
          case "8":
            type = "後期高齢者医療";
            break;
          case "9":
            type = "公費負担医療";
        }

        switch (burden_ratio) {
          case "":
            ratio = "未選択";
            break;
          case "0":
            ratio = "１0割";
            break;
          case "1":
            ratio = "１割";
            break;
          case "2":
            ratio = "２割";
            break;
          case "3":
            ratio = "３割";
        }

        let agree;
        switch (personal_info_agreement) {
          case "":
            agree = "未選択";
            break;
          case "1":
            agree = "不合意";
            break;
          case "2":
            agree = "合意";
            break;
        }

        this.setState({
          tel,
          cel,
          name,
          nameKana,
          genre,
          birthDate: birthday,
          address,
          email,
          type,
          ratio,
          agree
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
    // console.log("state", this.state);
    return (
      <Fragment>
        {/* Name Field */}
        <div className="row">
          <label>顧客氏名</label>
          <div className="fields">
            <div>{this.state.name}</div>
          </div>
        </div>

        <div className="row">
          <label>顧客氏名カナ</label>
          <div className="fields">
            <div>{this.state.nameKana}</div>
          </div>
        </div>

        <div className="row">
          <label>携帯電話番号</label>
          <div className="fields">
            <div>{this.state.cel}</div>
          </div>
        </div>

        <div className="row">
          <label>自宅電話番号</label>
          <div className="fields">
            <div>{this.state.tel}</div>
          </div>
        </div>

        <div className="row">
          <label>性別</label>
          <div className="fields">
            <div>{this.state.genre}</div>
          </div>
        </div>

        <div className="row">
          <label>顧客生年月日</label>
          <div className="fields">
            <div>{this.state.birthDate}</div>
          </div>
        </div>

        <div className="row">
          <label>住所</label>
          <div className="fields">
            <div>{this.state.address}</div>
          </div>
        </div>

        <div className="row">
          <label>顧客E-mail１</label>
          <div className="fields">
            <div>{this.state.email}</div>
          </div>
        </div>

        <div className="row">
          <label>保険証種類</label>
          <div className="fields">
            <div>{this.state.type}</div>
          </div>
        </div>

        <div className="row">
          <label>負担割合</label>
          <div className="fields">
            <div>{this.state.ratio}</div>
          </div>
        </div>

        <div className="row">
          <label>個人情報の約諾書受領有無</label>
          <div className="fields">
            <div>{this.state.agree}</div>
          </div>
        </div>
      </Fragment>
    );
  }
}
