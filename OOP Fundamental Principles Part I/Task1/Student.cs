using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task1
{
    class Student : People
    {
        public string ClassNumber { get; set; }

        public string Comment { get; set; }
  
        public Student(string name, string classNumber)
        {
            this.Name = name;
            this.ClassNumber = classNumber;
        }

    }
}
