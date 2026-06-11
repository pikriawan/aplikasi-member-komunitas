const InvoiceStatus = {
    Unpaid: {
        value: "unpaid",
        label: "Belum dibayar",
        variant: "danger"
    },
    Paid: {
        value: "paid",
        label: "Dibayar",
        variant: "warning"
    },
    Verified: {
        value: "verified",
        label: "Diverifikasi",
        variant: "success"
    },
    Canceled: {
        value: "canceled",
        label: "Dibatalkan",
        variant: "warning"
    }
};

InvoiceStatus.from = function (value) {
    for (const [k, v] of Object.entries(InvoiceStatus)) {
        if (v.value === value) {
            return InvoiceStatus[k];
        }
    }

    return null;
};

InvoiceStatus.entries = function () {
    return Object.entries(InvoiceStatus).filter(([, v]) => typeof v === "object");
}

export default InvoiceStatus;
