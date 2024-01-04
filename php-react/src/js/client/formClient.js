import React, { Component, Fragment } from 'react';
import { render } from 'react-dom';
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/ja.js';
import { DatePicker, DatePickerInput } from 'rc-datepicker';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faWindowClose, faCalendarAlt, faSearchLocation } from '@fortawesome/free-solid-svg-icons';
import '../../sass/main.scss';
import { API_URL } from '../constants';

export default class FormClient extends Component {
	constructor(props) {
		super(props);

		this.state = {
			id: 0,
			telL: '',
			telC: '',
			telR: '',
			celL: '',
			celC: '',
			celR: '',
			lastName: '',
			firstName: '',
			lastNameKana: '',
			firstNameKana: '',
			genre: '',
			birthYear: '',
			birthMonth: '',
			birthDay: '',
			postalCodePrefix: '',
			postalCodeSufix: '',
			address1: '',
			address2: '',
			address3: '',
			address4: '',
			email: '',
			insuranceType: '',
			ratio: '',
			agreement: '',
			showPicker: false,
			// sendStatus: ""
		};
		this.initialState = {...this.state};
		this.handleChange = this.handleChange.bind(this);
		this.getAddress = this.getAddress.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
	}

	componentWillMount() {
		if (localStorage.getItem("movingState") !== null) {
			this.setState(JSON.parse(localStorage.getItem("movingState")));
		  }
	}

	getAddress(event) {
		event.preventDefault();
		let postalCode;
		this.setState({
			address1: '',
			address2: '',
			address3: '',
			address4: ''
		});
		postalCode = parseInt(`${this.state.postalCodePrefix}${this.state.postalCodeSufix}`);
		axios.get(`${API_URL}postalCodeStr.json`).then((response) => {
			const addresses = response.data;
			const address = addresses.filter((add) => add.code === postalCode);
			if (typeof address[0] == 'undefined') {
				alert('住所見つかりませんでした。');
			}
			this.setState({
				address1: address[0].a1,
				address2: address[0].a2,
				address3: address[0].a3
			});
		});
	}

	onChangePicker(jsDate) {
		this.setState({
			birthYear: moment(jsDate).format('YYYY'),
			birthMonth: moment(jsDate).format('MM'),
			birthDay: moment(jsDate).format('DD'),
			birthDate: `${moment(jsDate).format('YYYY')}-${moment(jsDate).format('MM')}-${moment(jsDate).format('DD')}`,
			showPicker: false
		});
	}

	onClickPicker() {
		this.setState({ showPicker: !this.state.showPicker });
	}

	handleChange(event) {
		const name = event.target.getAttribute('name');
		const value = event.target.value;
		this.setState({ [name]: value });
	}
	handleDismissModal() {
		console.log('closing modal...');
	}

	handleBlur() {}

	handleSubmit(event) {
		const tel =
			this.state.telL && this.state.telC && this.state.telR
				? `${this.state.telL}-${this.state.telC}-${this.state.telR}`
				: '';
		const cel =
			this.state.celL && this.state.celC && this.state.celR
				? `${this.state.celL}-${this.state.celC}-${this.state.celR}`
				: '';
		const birthdate =
			this.state.birthYear && this.state.birthMonth && this.state.birthDay
				? `${this.state.birthYear}-${this.state.birthMonth}-${this.state.birthDay}`
				: '';
		const postalCode =
			this.state.postalCodePrefix && this.state.postalCodeSufix
				? `${this.state.postalCodePrefix}-${this.state.postalCodeSufix}`
				: '';
		axios.post(`${API_URL}updateClient.php`, {
			id: this.state.id,
			tel,
			cel,
			lastName: this.state.lastName,
			firstName: this.state.firstName,
			lastNameKana: this.state.lastNameKana,
			firstNameKana: this.state.firstNameKana,
			genre: this.state.genre,
			birthdate,
			postalCode,
			address1: this.state.address1,
			address2: this.state.address2,
			address3: this.state.address3,
			address4: this.state.address4,
			email: this.state.email,
			insuranceType: this.state.insuranceType,
			ratio: this.state.ratio,
			agreement: this.state.agreement
		})
		.then(response => {
			if (response.data === "success") {
				this.setState(this.initialState);
				if (localStorage.getItem("clientState") !== null) {
					localStorage.removeItem("clientState");
				}
				// this.setState({sendStatus: "success"});
			} else if (response.data === "failed") {
				localStorage.setItem("clientState", JSON.stringify(this.state));
				// this.setState({sendStatus: "failed"});
			}
			// const sendStatus = this.state.sendStatus;
			// this.props.sendStatus({sendStatus});
		})
		.catch(function(error) {
			console.log(error);
		})
		;
	}

	render() {
		const date = moment();
		// console.log(this.state);
		return (
			<Fragment>
				<h1>顧客登録</h1>
				<div className="row">
					<div className="col">＊</div>
					<div className="col">必須入力</div>
				</div>
				<div className="row">
					<label>携帯電話番号　＊</label>
					<div className="fields">
						<div className="col">
							<input type="text" name="celL" value={this.state.celL} onChange={this.handleChange} />
							<span>-</span>
							<input type="text" name="celC" value={this.state.celC} onChange={this.handleChange} />
							<span>-</span>
							<input type="text" name="celR" value={this.state.celR} onChange={this.handleChange} />
						</div>
					</div>
				</div>
				<div className="row">
					<label>自宅電話番号　＊</label>
					<div className="fields">
						<div className="col">
							<input type="text" name="telL" value={this.state.telL} onChange={this.handleChange} />
							<span>-</span>
							<input type="text" name="telC" value={this.state.telC} onChange={this.handleChange} />
							<span>-</span>
							<input type="text" name="telR" value={this.state.telR} onChange={this.handleChange} />
						</div>
					</div>
				</div>
				<div className="row">
					<label>顧客氏名（姓）　＊</label>
					<div className="fields">
						<div className="col">
							<input
								type="text"
								name="lastName"
								value={this.state.lastName}
								onChange={this.handleChange}
							/>
							<label>（名）</label>
							<input
								type="text"
								name="firstName"
								value={this.state.firstName}
								onChange={this.handleChange}
							/>
						</div>
					</div>
				</div>
				<div className="row">
					<label>顧客氏名カナ（姓）　＊</label>
					<div className="fields">
						<div className="col">
							<input
								type="text"
								name="lastNameKana"
								value={this.state.lastNameKana}
								onChange={this.handleChange}
							/>
							<label>カナ（名）</label>
							<input
								type="text"
								name="firstNameKana"
								value={this.state.firstNameKana}
								onChange={this.handleChange}
							/>
						</div>
					</div>
				</div>
				<div className="row">
					<label>性別　＊</label>
					<div className="fields">
						<select name="genre" value={this.state.genre} onChange={this.handleChange}>
							<option value="">選択</option>
							<option value="1">男性</option>
							<option value="2">女性</option>
						</select>
					</div>
				</div>
				<div className="row">
					<label>顧客生年月日　＊</label>
					<div className="fields" style={{ position: 'relative' }}>
						<input
							type="text"
							name="birthYear"
							className="inputDate"
							value={this.state.birthYear}
							onChange={this.handleChange}
						/>
						<span>年</span>
						<input
							type="text"
							name="birthMonth"
							className="inputDate"
							value={this.state.birthMonth}
							onChange={this.handleChange}
						/>
						<span>月</span>
						<input
							type="text"
							name="birthDay"
							className="inputDate"
							value={this.state.birthDay}
							onChange={this.handleChange}
						/>
						<span>日</span>
						<span style={{ position: 'relative' }}>
							<FontAwesomeIcon
								icon={faCalendarAlt}
								size="2x"
								style={{ position: 'relative', fontSize: '2.1rem' }}
								color="#3498DB"
								onClick={this.onClickPicker.bind(this)}
							/>
							{this.state.showPicker && (
								<DatePicker
									locale="ja"
									onChange={this.onChangePicker.bind(this)}
									value={date}
									style={{
										position: 'absolute',
										top: '3.25rem',
										left: '50%',
										transform: 'translateX(-50%)',
										boxShadow: '10px 10px 8px -5px rgba(0,0,0,0.17)',
										zIndex: 1
									}}
								/>
							)}
						</span>
					</div>
				</div>
				<div className="row">
					<label>顧客郵便番号　＊</label>
					<div className="fields">
						<input
							type="text"
							name="postalCodePrefix"
							value={this.state.postalCodePrefix}
							onChange={this.handleChange}
						/>
						<span>-</span>
						<input
							type="text"
							name="postalCodeSufix"
							value={this.state.postalCodeSufix}
							onChange={this.handleChange}
						/>
						<FontAwesomeIcon
							icon={faSearchLocation}
							size="2x"
							style={{ marginLeft: '1rem', position: 'relative' }}
							color="#3498DB"
							onClick={this.getAddress}
						/>
					</div>
				</div>
				<div className="row">
					<label>顧客住所</label>
					<div className="fields address">
						<input
							type="text"
							name="address1"
							placeholder="都道府県"
							value={this.state.address1}
							onChange={this.handleChange}
						/>
						<input
							type="text"
							name="address2"
							placeholder="市区"
							value={this.state.address2}
							onChange={this.handleChange}
						/>
						<input
							type="text"
							name="address3"
							placeholder="町村　番地"
							value={this.state.address3}
							onChange={this.handleChange}
						/>
						<input
							type="text"
							name="address4"
							placeholder="マンション名部屋番号"
							value={this.state.address4}
							onChange={this.handleChange}
						/>
					</div>
				</div>
				<div className="row">
					<label>顧客E-mail１　＊</label>
					<div className="fields">
						<input type="text" name="email" value={this.state.email} onChange={this.handleChange} />
					</div>
				</div>
				<div className="row">
					<label>保険証種類</label>
					<div className="fields">
						<select name="insuranceType" value={this.state.insuranceType} onChange={this.handleChange}>
							<option value="">選択</option>
							<option value="1">協会けんぽ</option>
							<option value="2">船舶保険</option>
							<option value="3">日雇健康保険</option>
							<option value="4">組合けんぽ</option>
							<option value="5">自衛官診療証</option>
							<option value="6">共済組合</option>
							<option value="7">国保</option>
							<option value="8">後期高齢者医療</option>
							<option value="9">公費負担医療</option>
						</select>
						<span>※整骨院、整体院の場合、選択してください。</span>
					</div>
				</div>
				<div className="row">
					<label>負担割合</label>
					<div className="fields">
						<select name="ratio" value={this.state.ratio} onChange={this.handleChange}>
							<option value="">選択</option>
							<option value="0">１0割</option>
							<option value="1">１割</option>
							<option value="2">２割</option>
							<option value="3">３割</option>
						</select>
						<span>※整骨院、整体院の場合、選択してください。</span>
					</div>
				</div>
				<div className="row">
					<label>個人情報の約諾書受領有無</label>
					<div className="fields">
						<select name="agreement" value={this.state.agreement} onChange={this.handleChange}>
							<option value="">選択</option>
							<option value="0">不合意</option>
							<option value="1">合意</option>
						</select>
					</div>
				</div>
				<div className="modal__content--footer" style={{ margin: '2rem -2rem -2rem -2rem' }}>
					<div className="modal__content--footer-buttons">
						<button className="btn" onClick={this.handleDismissModal.bind(this)}>
							閉じる
						</button>
						<button className="btn btn__primary" onClick={this.handleSubmit}>
							登録
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

render(<FormClient />, document.getElementById('formClient'));
