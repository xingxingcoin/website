interface FinanceData {
    marketCap: number,
    priceChange: number
}

export default interface XingFinanceDataResponse {
    finance: FinanceData
    url: string
}
