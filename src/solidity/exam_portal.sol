// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.4;
contract answers {
    struct student {
        string id;
    }
    struct answer {
        uint[] aarr;
    }
    mapping(string => student[]) stu;
    mapping(string => answer) ans;
    function submitAnswer(string memory _pid, string memory _id, uint[] memory _arr) public {
        student memory std;
        std.id = _id;
        stu[_pid].push(std);
        ans[_id].aarr = _arr;
    }
    function getAnswer(string memory _pid, string memory _id) public view returns(uint[] memory temp) {
        student[] memory std;
        std = stu[_pid];
        for(uint i=0; i<std.length; i++) {
            if(keccak256(bytes(std[i].id)) == keccak256(bytes(_id))) {
                temp = ans[_id].aarr;
            }
            else {
                continue;
            }
        }
    }
}
