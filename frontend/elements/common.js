import moment from "moment";
import { getUserWallet } from "./user";

export const formatMoney = (amount) => {
    return new Intl.NumberFormat('en-NG', { style: 'currency', currency: 'USD' }).format(amount)
}

export const formatDate = (date) => {
    return moment(date).format('MMMM Do YYYY, h:mm:ss a');
};


// If user has a wallet :: Godfred
export const userBalance = () => {
    const wallet = getUserWallet();
    return wallet.balance;
} 
