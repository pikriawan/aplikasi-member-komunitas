const UserRole = {
    Member: {
        value: "member",
        label: "Member",
        variant: "success"
    },
    Staff: {
        value: "staff",
        label: "Petugas",
        variant: "warning"
    },
    Finance: {
        value: "finance",
        label: "Keuangan",
        variant: "danger"
    },
    Leader: {
        value: "leader",
        label: "Ketua",
        variant: "info"
    },
    SuperAdmin: {
        value: "super_admin",
        label: "Super Admin",
        variant: "primary"
    }
};

UserRole.from = function (value) {
    for (const [k, v] of Object.entries(UserRole)) {
        if (v.value === value) {
            return UserRole[k];
        }
    }

    return null;
};

UserRole.entries = function () {
    return Object.entries(UserRole).filter(([, v]) => typeof v === "object");
}

export default UserRole;

